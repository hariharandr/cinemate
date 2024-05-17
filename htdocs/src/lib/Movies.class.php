<?php
class Movies
{
    public static function getMovies($page = 1, $limit = 10)
    {
        $skip = ($page - 1) * $limit;
        try {
            $collection = Database::getConnection()->selectCollection('title_basics');

            $pipeline = [
                [
                    '$match' => [
                        'primaryTitle' => [
                            '$exists' => true,
                            '$ne' => '',
                        ],
                        'titleType' => 'movie'
                    ]
                ],
                [
                    '$limit' => $limit
                ],
                [
                    '$skip' => $skip
                ]
            ];
            $cursor = $collection->aggregate($pipeline);
            $data = $cursor->toArray();
            return $data;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return ['error' => $e->getMessage()];
        }
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
}
