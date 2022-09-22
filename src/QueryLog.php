<?php namespace Haruncpi\QueryLog;

use Haruncpi\QueryLog\Supports\JsonLogFileWriter;
use Haruncpi\QueryLog\Supports\TextLogFileWriter;
use Illuminate\Support\Facades\DB;

/**
 * QueryLog Class
 * @since 1.0.0
 */
class QueryLog
{
    const FORMAT_TEXT = 'text';
    const FORMAT_JSON = 'json';

    /**
     * @var string file name for query log inside storage directory
     */
    private $file_name = 'query.log';

    /**
     * @var string file format of query log. default is text. available text,json
     */
    private $format;

    /**
     * @var string $file_path use for get the absolute path
     */
    private $file_path;

    /**
     * @var int calculate the total number of query.
     */
    private $total_query;

    /**
     * @var int calculate the total amount of query time.
     */
    private $total_time;

    /**
     * @var array file data for writing data into file.
     */
    private $final;


    /**
     * QueryLog constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->file_path = storage_path($this->file_name);
        $this->format = trim(env('QUERY_LOG_FORMAT', self::FORMAT_TEXT));
        $this->total_query = 0;
        $this->total_time = 0;
        $this->final = [];

        if (!in_array(strtolower($this->format), [self::FORMAT_TEXT, self::FORMAT_JSON])) {
            throw new \Exception('Invalid query log data file format. Support text or json file format.');
        }

        if (file_exists($this->file_path)) {
            unlink($this->file_path);
        }


        $this->listenQueries();
    }


    /**
     * Query listener
     * @return void
     *
     * @since 1.0.0
     */
    private function listenQueries()
    {

        DB::listen(function ($query) {
            $this->total_query++;
            $this->total_time += $query->time;

            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            foreach ($backtrace as $trace) {
                if (array_key_exists('file', $trace) && array_key_exists('line', $trace)) {
                    if (strpos($trace['file'], base_path('app')) !== false) {
                        $this->addQuery($query, $trace);
                        break;
                    }
                }
            }
        });

        app()->terminating(function () {

            $this->final['meta'] = [
                'url'         => request()->url(),
                'method'      => request()->method(),
                'total_query' => $this->total_query,
                'total_time'  => $this->total_time
            ];

            if ($this->format == self::FORMAT_JSON && isset($this->final['queries'])) {
                (new JsonLogFileWriter)->write($this->file_path, $this->final);
            }

            if ($this->format == self::FORMAT_TEXT && isset($this->final['queries'])) {
                (new TextLogFileWriter)->write($this->file_path, $this->final);
            }
        });
    }

    /**
     * Make final query from sql bindings
     *
     * @param $query
     * @return string
     *
     * @since 1.0.0
     */
    private function getSqlWithBindings($query)
    {
        return vsprintf(str_replace('?', '%s', $query->sql), collect($query->bindings)
            ->map(function ($binding) {
                return is_numeric($binding) ? $binding : "'{$binding}'";
            })->toArray());
    }


    /**
     * add each query in a specific array format
     *
     * @param object $query
     * @param array $trace
     * @return void
     *
     * @since 1.0.0
     */
    private function addQuery($query, $trace)
    {
        $queryStr = $this->getSqlWithBindings($query);
        $time = $query->time;
        $file = $trace['file'];
        $line = $trace['line'];


        $this->final['queries'][] = [
            'sl'          => $this->total_query,
            'query'       => $query->sql,
            'bindings'    => $query->bindings,
            'final_query' => $queryStr,
            'time'        => $time,
            'file'        => $file . ":$line",
            'line'        => $line
        ];
    }
}
