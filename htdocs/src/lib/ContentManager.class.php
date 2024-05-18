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
        return $cursor->toArray();
    }


    public static function searchMoview($search_term = '', $page = 1, $limit = 10)
    {
        if (empty($search_term)) {
            return ['error' => 'Search term is required'];
        }
        try {
            // pagination
            $skip = ($page - 1) * $limit;

            $collection = Database::getConnection()->selectCollection('title_basics');
            $pipeline = [
                ['$match' => ['$text' => ['$search' => $search_term]]],
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
                    'title' => ['$first' => '$primaryTitle'],
                    'originalTitle' => ['$first' => '$originalTitle'],
                    'genres' => ['$first' => '$genres'],
                    'year' => ['$first' => '$startYear'],
                    'runtime' => ['$first' => '$runtimeMinutes'],
                    'type' => ['$first' => '$titleType'],
                    'ratings' => ['$first' => '$ratings.averageRating'],
                    'votes' => ['$first' => '$ratings.numVotes'],
                    'cast_and_crew' => ['$addToSet' => '$cast_details.primaryName']
                ]],
                ['$project' => [
                    '_id' => 0,
                    'title' => 1,
                    'originalTitle' => 1,
                    'genres' => 1, 'year' => 1,
                    'runtime' => 1,
                    'type' => 1,
                    'ratings' => 1,
                    'votes' => 1,
                    'cast_and_crew' => 1
                ]]
            ];
            // due to db limitations, and server limitations, we will limit the search to 10 results
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

    // Fetch TV Episodes
    public static function getEpisodes($page = 1, $limit = 10)
    {
        $skip = ($page - 1) * $limit;
        $collection = self::getConnection()->selectCollection('title_basics');
        $query = [
            'titleType' => 'tvEpisode'
        ];
        $options = [
            'limit' => $limit,
            'skip' => $skip,
            'sort' => ['startYear' => -1]
        ];
        $cursor = $collection->find($query, $options);
        return $cursor->toArray();
    }

    // Fetch Cast and Crew
    public static function getCast($page = 1, $limit = 10)
    {
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
            ['$limit' => $limit],
            ['$skip' => $skip]
        ];
        $cursor = $collection->aggregate($pipeline);
        return $cursor->toArray();
    }
}
