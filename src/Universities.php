<?php
/**
 * Copyright 2019, sebastian moderlak (https://github.com/sem4711/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2019, sebastian moderlak (https://github.com/sem4711/)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace sem4711\Universitylist;

/**
 * Class Universities
 * @package sem4711\universitylist
 */
class Universities
{
    /**
     * @var array
     */
    private $meta = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * Universities constructor
     *
     * @param string $lang Language Key to initiate
     */
    public function __construct(string $lang) {

        $this->read($lang);
    }

    /**
     * read input file from language key
     *
     * @param string $lang 2 digits language code
     */
    private function read($lang) {

        // check existing data
        $input = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'universities.' . $lang . '.json';

        if(!file_exists($input)) {
            throw new Exception("cannot find data definition for language '{$lang}' in input file '{$input}'");
        }

        // check existing content
        $data = file_get_contents($input);
        $data = mb_convert_encoding($data, 'UTF-8', mb_detect_encoding($data, 'UTF-8,ISO-8859-1', true));

        if(empty($data)) {
            throw new Exception("empty data file for language '{$lang}' in input file '{$input}'");
        }

        // handle content as json data
        $json = json_decode($data);

        if(json_last_error()!==JSON_ERROR_NONE) {
            $error = json_last_error_msg();
            throw new Exception("error reading data file for lanugage '{$lang}' in input file '{$input}': " . ($error===false ? 'unknown error' : $error));
        }

        // validate input structure
        foreach(['name', 'date', 'version', 'authors', 'data'] as $key) {
            if(!array_key_exists($key, $json)) {
                throw new Exception("error reading file structure for lanugage '{$lang}' in input file '{$input}': missing key '{$key}'");
            }
        }

        $this->meta = [
            'name' => $json->name,
            'date' => $json->date,
            'version' => $json->version,
            'authors' => $json->authors,
        ];

        $this->data = $json->data;
    }

    /**
     * get the meta data
     *
     * @return array
     */
    public function getMeta() {
        return $this->meta;
    }

    /**
     * get the beef
     *
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * find dataset of university by given exact name and return the first matching array result
     * otherwise it will return null
     *
     * @return array|null
     */
    public function findUniversity($name) {

        foreach($this->data as $key => $university) {
            if($university->name===$name) {
                return $this->data[$key];
            }
        }

        // nothing found...
        return null;
    }
}
