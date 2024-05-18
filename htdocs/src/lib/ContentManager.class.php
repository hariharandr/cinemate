<?php
class ContentManager
{
    // Database connection setup should be configured to get MongoDB connection
    private static function getConnection()
    {
        return Database::getConnection();
    }

    // Fetch Movies
    public static function getMovies($page = 1, $limit = 10)
    {
        $cacheFile = '/home/Jawahar.s/cache/movies' . $page . '.json'; // Define cache file path

        // Check if cache file exists and is not too old
        if (file_exists($cacheFile)) { // Cache duration 1 week
            return json_decode(file_get_contents($cacheFile), true); // Return data from cache
        } else {
            $skip = ($page - 1) * $limit;
            $collection = self::getConnection()->selectCollection('title_basics');
            $query = [
                'titleType' => 'movie'
            ];
            $options = [
                'limit' => $limit,
                'skip' => $skip,
                'sort' => ['startYear' => -1] // Sorting by year in descending order
            ];
            $cursor = $collection->find($query, $options);
            $result =  $cursor->toArray();
            // Save the result to a cache file
            file_put_contents($cacheFile, json_encode($result));
            return $result;
        }
    }


    public static function searchMoview($search_term = '', $type = 'all', $page = 1, $limit = 10)
    {
        if (empty($search_term)) {
            return ['error' => 'Search term is required'];
        }
        try {
            $skip = ($page - 1) * $limit;
            $collection = Database::getConnection()->selectCollection('title_basics');

            // Dynamically build the initial match condition based on the type
            $matchCondition = ['$text' => ['$search' => $search_term]];
            if ($type !== 'all') {
                $matchCondition['titleType'] = $type === 'episodes' ? 'tvEpisode' : ($type === 'movies' ? 'movie' : null);
            }

            $pipeline = [
                ['$match' => $matchCondition],
                ['$lookup' => ['from' => 'title_ratings', 'localField' => 'tconst', 'foreignField' => 'tconst', 'as' => 'ratings']],
                ['$unwind' => ['path' => '$ratings', 'preserveNullAndEmptyArrays' => true]],
                ['$lookup' => [
                    'from' => 'title_principals',
                    'localField' => 'tconst',
                    'foreignField' => 'tconst',
                    'as' => 'principals'
                ]],
                ['$lookup' => [
                    'from' => 'name_basics',
                    'localField' => 'principals.nconst',
                    'foreignField' => 'nconst',
                    'as' => 'cast_details'
                ]],
                ['$group' => [
                    '_id' => '$tconst',
                    'primaryTitle' => ['$first' => '$primaryTitle'],
                    'originalTitle' => ['$first' => '$originalTitle'],
                    'genres' => ['$first' => '$genres'],
                    'startYear' => ['$first' => '$startYear'],
                    'runtimeMinutes' => ['$first' => '$runtimeMinutes'],
                    'titleType' => ['$first' => '$titleType'],
                    'ratings' => ['$first' => '$ratings.averageRating'],
                    'votes' => ['$first' => '$ratings.numVotes'],
                    'cast_and_crew' => ['$addToSet' => '$cast_details.primaryName'],
                ]],
                ['$project' => [
                    '_id' => 0,
                    'primaryTitle' => 1,
                    'originalTitle' => 1,
                    'genres' => 1,
                    'startYear' => 1,
                    'runtimeMinutes' => 1,
                    'titleType' => 1,
                    'ratings' => 1,
                    'votes' => 1,
                    'cast_and_crew' => 1,
                    'isAdult' => 1
                ]]
            ];

            $options = [
                'limit' => $limit,
                'skip' => $skip
            ];
            $cursor = $collection->aggregate($pipeline, $options);
            $data = $cursor->toArray();
            return $data;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    // Fetch TV Episodes with caching
    public static function getEpisodes($page = 1, $limit = 10)
    {
        $cacheFile = '/home/Jawahar.s/cache/episodes_page_' . $page . '.json'; // Define cache file path

        // Check if cache file exists and is not too old
        if (file_exists($cacheFile)) { // Cache duration 1 week
            return json_decode(file_get_contents($cacheFile), true); // Return data from cache
        } else {
            $skip = ($page - 1) * $limit;
            $collection = self::getConnection()->selectCollection('title_basics');
            $query = [
                'titleType' => 'tvEpisode',
            ];
            $options = [
                'limit' => $limit,
                'skip' => $skip,
                'sort' => ['startYear' => -1]
            ];
            $cursor = $collection->find($query, $options);
            $result = $cursor->toArray();

            // Save the result to a cache file
            file_put_contents($cacheFile, json_encode($result));

            return $result;
        }
    }


    // Fetch Cast and Crew
    public static function getCast($page = 1, $limit = 10)
    {
        $cacheFile = '/home/Jawahar.s/cache/cast' . $page . '.json'; // Define cache file path

        // Check if cache file exists and is not too old
        if (file_exists($cacheFile)) { // Cache duration 1 week

            return json_decode(file_get_contents($cacheFile), true); // Return data from cache
        } else {
            $skip = ($page - 1) * $limit;
            $collection = self::getConnection()->selectCollection('title_principals');
            $pipeline = [
                ['$lookup' => [
                    'from' => 'name_basics',
                    'localField' => 'nconst',
                    'foreignField' => 'nconst',
                    'as' => 'person_info'
                ]],
                ['$unwind' => '$person_info'],
                ['$unwind' => '$person_info.knownForTitles'], // Ensuring each knownForTitle is processed separately
                ['$lookup' => [
                    'from' => 'title_basics',
                    'localField' => 'person_info.knownForTitles',
                    'foreignField' => 'tconst',
                    'as' => 'title_info'
                ]],
                ['$unwind' => [
                    'path' => '$title_info',
                    'preserveNullAndEmptyArrays' => true // To keep records even if no title_info is found
                ]],
                ['$group' => [ // Grouping back by nconst to collect all titles
                    '_id' => '$person_info.nconst',
                    'primaryName' => ['$first' => '$person_info.primaryName'],
                    'primaryProfession' => ['$first' => '$person_info.primaryProfession'],
                    'birthYear' => ['$first' => '$person_info.birthYear'],
                    'deathYear' => ['$first' => '$person_info.deathYear'],
                    'knownForTitles' => ['$push' => '$title_info.primaryTitle'] // Collecting all known titles
                ]],
                ['$project' => [
                    '_id' => 0,
                    'name' => '$primaryName',
                    'knownFor' => '$knownForTitles',
                    'profession' => '$primaryProfession',
                    'birthYear' => 1,
                    'deathYear' => 1
                ]],
                ['$limit' => $limit],
                ['$skip' => $skip]
            ];
            $cursor = $collection->aggregate($pipeline);
            $result = $cursor->toArray();
            // Save the result to a cache file
            file_put_contents($cacheFile, json_encode($result));
            return $result;
        }
    }
}
