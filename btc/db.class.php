<?php

/**
 * Exception helper for the Database class
 
Database.class.php
============

Database.class.php is a simple PHP class for doing standard MySQL actions, such as selecting, inserting, updating and deleting database rows. 
It also includes some nice functionality, like auto-escaping to protect your database from malicious code and automatic serializing of arrays.

## Usage
### Initiating
**Initiate a database connection using by creating a `new Database()` object.**
``
require_once('Database.class.php');

$db = new Database($database_name, $username, $password, $host); // $host is optional and defaults to 'localhost'
```

### Select
**Select rows from a database table**

Usage:

```
$db->select($table, $where, $limit, $order, $where_mode, $select_fields)
```

Arguments:

* string `$table` - name of the table to select from
* array/string `$where` - array or string holding the filters/'WHERE' clause for the query
* int/string `$limit` - integer or string holding the 'LIMIT' clause
* string `$order` - string holding the 'ORDER BY' clause
* string `$where_mode` - whether to add an 'AND' or 'OR' after each item in the `$where` array, defaults to `AND`
* string `$select_fields` - the fields to select (SELECT <$select_fields> FROM ...), defaults to `*`

Example:

```
// get the first 10 candy bars that are sweet, and order them by amount
$db->select('candy', array('sweet' => 1, 'spicy' => 0), 10, 'amount DESC');
```

```
// get the ids 1, 2,5,9  from products
$db->select('products', array('id' => 'in (1,2,5,9)'), false, false,'OR');
```



#### Reading results

Reading the results can be done with the following functions:

* `$db->count()` returns the number of selected rows, equal to `mysql_num_rows()`

* `$db->row()` returns the first row that matches the query as an array
* `$db->result()` returns all matches rows as an array containing row objects

* `$db->result_array()` returns all matches rows as an array containing row arrays
* `$db->row_array()` returns the first row that matches the query as an object (stdClass)

Please note that you can call any of these functions also directly after the `$db->select()` call, like shown below:

```
echo $db->select('candy', array('sweet' => 1), 10)->count();
```

There are a few other methods available for queries that might come in handy:

* `$db->sql()` returns the sql query that was last executed


### Insert
**Insert data into a database table**

Usage:

```
$db->insert($table, $fields=array())
```

Example:

```
$db->insert(
	'candy',
	array(
		'name' => 'Kitkat original',
		'sweet' => 1,
		'spicey' => 0,
		'brand' => 'Kitkat',
		'amount_per_pack' => 4
	)
);
```

**Tip!** You can call `$db->id()` immeadiately after a `$db->insert()` call to get the ID of the last inserted row.

### Update
**Update one or more rows of a database table**

Usage:

```
$db->update($table, $fields=array(), $where=array())
```

Example:

```
// set amount per pack to 5 for all Kitkats
$db->update(
	'candy',
	array( // fields to be updated
		'amount_per_pack' => 5
	),
	array( // 'WHERE' clause
		'brand' => 'Kitkat'
	)
);
```

### Delete
**Remove one or more rows from a database table**

Usage:

```
$db->delete($table, $where=array())
```

Example:

```
// delete all Kitkat candy
$db->delete(
	'candy',
	array( // 'WHERE' clause
		'brand' => 'Kitkat'
	)
);
```

### Singleton
**Access the database instance outside the global scope after initializing it**

Usage:

```
$my_db = Database::instance();
```

Example:

```
// Global scope
$db = new Database($database_name, $username, $password, $host);

// Function scope
function something(){
    // We could simply use `global $db;`, but using globals is bad. Instead we can do this:
    $db = Database::instance();

    // And now we have access to $db inside the function
}
``
 */
class DatabaseException extends Exception
{
    // Default Exception class handles everything
}
/**
 * A basic database interface using MySQLi
 */
class Database
{

    private $sql;
    private $mysql;
    private $result;
    private $result_rows;
    private $database_name;
    private static $instance;

    /**
     * Query history
     *
     * @var array
     */
    static $queries = array();

    /**
     * Database() constructor
     *
     * @param string $database_name
     * @param string $username
     * @param string $password
     * @param string $host
     * @throws DatabaseException
     */
    function __construct($database_name, $username, $password, $host = 'localhost')
    {
        self::$instance = $this;

        $this->database_name = $database_name;
        $this->mysql = mysqli_connect($host, $username, $password, $database_name);

        if (!$this->mysql) {
            throw new DatabaseException('Database connection error: ' . mysqli_connect_error());
        }
    }

    /**
     * Get instance
     *
     * @param string $database_name
     * @param string $username
     * @param string $password
     * @param string $host
     * @return Database
     */
    final public static function instance($database_name = null, $username = null, $password = null, $host = 'localhost')
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database($database_name, $username, $password, $host);
        }

        return self::$instance;
    }

    /**
     * Helper for throwing exceptions
     *
     * @param $error
     * @throws Exception
     */
    private function _error($error)
    {
        throw new DatabaseException('Database error: ' . $error);
    }

    /**
     * Turn an array into a where statement
     *
     * @param mixed $where
     * @param string $where_mode
     * @return string
     * @throws Exception
     */
    public function process_where($where, $where_mode = 'AND')
    {
        $query = '';
        if (is_array($where)) {
            $num = 0;
            $where_count = count($where);
            foreach ($where as $k => $v) {
                if (is_array($v)) {
                    $w = array_keys($v);
                    if (reset($w) != 0) {
                        throw new Exception('Can not handle associative arrays');
                    }
                    $query .= " `" . $k . "` IN (" . $this->join_array($v) . ")";
                } elseif (!is_integer($k)) {
                    $query .= ' `' . $k . "`='" . $this->escape($v) . "'";
                } else {
                    $query .= ' ' . $v;
                }
                $num++;
                if ($num != $where_count) {
                    $query .= ' ' . $where_mode;
                }
            }
        } else {
            $query .= ' ' . $where;
        }
        return $query;
    }

    /**
     * Perform a SELECT operation
     *
     * @param string $table
     * @param array $where
     * @param bool $limit
     * @param bool $order
     * @param string $where_mode
     * @param string $select_fields
     * @return Database
     * @throws DatabaseException
     */
    public function select($table, $where = array(), $limit = false, $order = false, $where_mode = "AND", $select_fields = '*')
    {
        $this->result = null;
        $this->sql = null;

        if (is_array($select_fields)) {
            $fields = '';
            foreach ($select_fields as $s) {
                $fields .= '`' . $s . '`, ';
            }
            $select_fields = rtrim($fields, ', ');
        }

        $query = 'SELECT ' . $select_fields . ' FROM `' . $table . '`';
        if (!empty($where)) {
            $query .= ' WHERE' . $this->process_where($where, $where_mode);
        }
        if ($order) {
            $query .= ' ORDER BY ' . $order;
        }
        if ($limit) {
            $query .= ' LIMIT ' . $limit;
        }
        return $this->query($query);
    }

    /**
     * Perform a query
     *
     * @param string $query
     * @return $this|Database
     * @throws Exception
     */
    public function query($query)
    {
        self::$queries[] = $query;
        $this->sql = $query;

        $this->result_rows = null;
        $this->result = mysqli_query($this->mysql, $query);

        if (mysqli_error($this->mysql) != '') {
            $this->_error(mysqli_error($this->mysql));
            $this->result = null;
            return $this;
        }

        return $this;
    }

    /**
     * Get last executed query
     *
     * @return string|null
     */
    public function sql()
    {
        return $this->sql;
    }

    /**
     * Get an array of objects with the query result
     *
     * @param string|null $key_field
     * @return array
     */
    public function result($key_field = null)
    {
        if (!$this->result_rows) {
            $this->result_rows = array();
            while ($row = mysqli_fetch_assoc($this->result)) {
                $this->result_rows[] = $row;
            }
        }

        $result = array();
        $index = 0;

        foreach ($this->result_rows as $row) {
            $key = $index;
            if (!empty($key_field) && isset($row[$key_field])) {
                $key = $row[$key_field];
            }
            $result[$key] = new stdClass();
            foreach ($row as $column => $value) {
                $this->is_serialized($value, $value);
                $result[$key]->{$column} = $this->clean($value);
            }
            $index++;
        }
        return $result;
    }

    /**
     * Get an array of arrays with the query result
     *
     * @return array
     */
    public function result_array()
    {
        if (!$this->result_rows) {
            $this->result_rows = array();
            while ($row = mysqli_fetch_assoc($this->result)) {
                $this->result_rows[] = $row;
            }
        }
        $result = array();
        $n = 0;
        foreach ($this->result_rows as $row) {
            $result[$n] = array();
            foreach ($row as $k => $v) {
                $this->is_serialized($v, $v);
                $result[$n][$k] = $this->clean($v);
            }
            $n++;
        }
        return $result;
    }

    /**
     * Get a specific row from the result as an object
     *
     * @param int $index
     * @return stdClass
     */
    public function row($index = 0)
    {
        if (!$this->result_rows) {
            $this->result_rows = array();
            while ($row = mysqli_fetch_assoc($this->result)) {
                $this->result_rows[] = $row;
            }
        }

        $num = 0;
        foreach ($this->result_rows as $column) {
            if ($num == $index) {
                $row = new stdClass();
                foreach ($column as $key => $value) {
                    $this->is_serialized($value, $value);
                    $row->{$key} = $this->clean($value);
                }
                return $row;
            }
            $num++;
        }

        return new stdClass();
    }

    /**
     * Get a specific row from the result as an array
     *
     * @param int $index
     * @return array
     */
    public function row_array($index = 0)
    {
        if (!$this->result_rows) {
            $this->result_rows = array();
            while ($row = mysqli_fetch_assoc($this->result)) {
                $this->result_rows[] = $row;
            }
        }

        $num = 0;
        foreach ($this->result_rows as $column) {
            if ($num == $index) {
                $row = array();
                foreach ($column as $key => $value) {
                    $this->is_serialized($value, $value);
                    $row[$key] = $this->clean($value);
                }
                return $row;
            }
            $num++;
        }

        return array();
    }

    /**
     * Get the number of result rows
     *
     * @return bool|int
     */
    public function count()
    {
        if ($this->result) {
            return mysqli_num_rows($this->result);
        } elseif (isset($this->result_rows)) {
            return count($this->result_rows);
        } else {
            return false;
        }
    }

    /**
     * Execute a SELECT COUNT(*) query on a table
     *
     * @param null $table
     * @param array $where
     * @param bool $limit
     * @param bool $order
     * @param string $where_mode
     * @return mixed
     */
    public function num($table = null, $where = array(), $limit = false, $order = false, $where_mode = "AND")
    {
        if (!empty($table)) {
            $this->select($table, $where, $limit, $order, $where_mode, 'COUNT(*)');
        }

        $res = $this->row();
        return $res->{'COUNT(*)'};
    }

    /**
     * Check if a table with a specific name exists
     *
     * @param $name
     * @return bool
     */
    function table_exists($name)
    {
        $res = mysqli_query($this->mysql, "SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '" . $this->escape($this->database_name) . "' AND table_name = '" . $this->escape($name) . "'");
        return ($this->mysqli_result($res, 0) == 1);
    }

    /**
     * Helper function for process_where
     *
     * @param $array
     * @return string
     */
    private function join_array($array)
    {
        $nr = 0;
        $query = '';
        foreach ($array as $key => $value) {
            if (is_object($value) || is_array($value) || is_bool($value)) {
                $value = serialize($value);
            }
            $query .= " '" . $this->escape($value) . "'";
            $nr++;
            if ($nr != count($array)) {
                $query .= ',';
            }
        }
        return trim($query);
    }

    /* Insert/update functions */

    /**
     * Insert a row in a table
     *
     * @param $table
     * @param array $fields
     * @param bool|false $appendix
     * @param bool|false $ret
     * @return bool|Database
     * @throws Exception
     */
    function insert($table, $fields = array(), $appendix = false, $ret = false)
    {
        $this->result = null;
        $this->sql = null;

        $query = 'INSERT INTO';
        $query .= ' `' . $this->escape($table) . "`";

        if (is_array($fields)) {
            $query .= ' (';
            $num = 0;
            foreach ($fields as $key => $value) {
                $query .= ' `' . $key . '`';
                $num++;
                if ($num != count($fields)) {
                    $query .= ',';
                }
            }
            $query .= ' ) VALUES ( ' . $this->join_array($fields) . ' )';
        } else {
            $query .= ' ' . $fields;
        }
        if ($appendix) {
            $query .= ' ' . $appendix;
        }
        if ($ret) {
            return $query;
        }
        $this->sql = $query;
        $this->result = mysqli_query($this->mysql, $query);
        if (mysqli_error($this->mysql) != '') {
            $this->_error(mysqli_error($this->mysql));
            $this->result = null;
            return false;
        } else {
            return $this;
        }
    }

    /**
     * Execute an UPDATE statement
     *
     * @param $table
     * @param array $fields
     * @param array $where
     * @param bool $limit
     * @param bool $order
     * @return $this|bool
     * @throws DatabaseException
     */
    function update($table, $fields = array(), $where = array(), $limit = false, $order = false)
    {
        if (empty($where)) {
            throw new DatabaseException('Where clause is empty for update method');
        }

        $this->result = null;
        $this->sql = null;
        $query = 'UPDATE `' . $table . '` SET';
        if (is_array($fields)) {
            $nr = 0;
            foreach ($fields as $k => $v) {
                if (is_object($v) || is_array($v) || is_bool($v)) {
                    $v = serialize($v);
                }
                $query .= ' `' . $k . "`='" . $this->escape($v) . "'";
                $nr++;
                if ($nr != count($fields)) {
                    $query .= ',';
                }
            }
        } else {
            $query .= ' ' . $fields;
        }
        if (!empty($where)) {
            $query .= ' WHERE' . $this->process_where($where);
        }
        if ($order) {
            $query .= ' ORDER BY ' . $order;
        }
        if ($limit) {
            $query .= ' LIMIT ' . $limit;
        }
        $this->sql = $query;
        $this->result = mysqli_query($this->mysql, $query);
        if (mysqli_error($this->mysql) != '') {
            $this->_error(mysqli_error($this->mysql));
            $this->result = null;
            return false;
        } else {
            return $this;
        }
    }

    /**
     * Execute a DELETE statement
     *
     * @param $table
     * @param array $where
     * @param string $where_mode
     * @param bool $limit
     * @param bool $order
     * @return $this|bool
     * @throws DatabaseException
     * @throws Exception
     */
    function delete($table, $where = array(), $where_mode = "AND", $limit = false, $order = false)
    {
        if (empty($where)) {
            throw new DatabaseException('Where clause is empty for update method');
        }

        // Notice: different syntax to keep backwards compatibility
        $this->result = null;
        $this->sql = null;
        $query = 'DELETE FROM `' . $table . '`';
        if (!empty($where)) {
            $query .= ' WHERE' . $this->process_where($where, $where_mode);
        }
        if ($order) {
            $query .= ' ORDER BY ' . $order;
        }
        if ($limit) {
            $query .= ' LIMIT ' . $limit;
        }
        $this->sql = $query;

        $this->result = mysqli_query($this->mysql, $query);
        if (mysqli_error($this->mysql) != '') {
            $this->_error(mysqli_error($this->mysql));
            $this->result = null;
            return false;
        } else {
            return $this;
        }
    }

    /**
     * Get the primary key of the last inserted row
     *
     * @return int|string
     */
    public function id()
    {
        return mysqli_insert_id($this->mysql);
    }

    /**
     * Get the number of rows affected by your last query
     *
     * @return int
     */
    public function affected()
    {
        return mysqli_affected_rows($this->mysql);
    }

    /**
     * Escape a parameter
     *
     * @param $str
     * @return string
     */
    public function escape($str)
    {
        return mysqli_real_escape_string($this->mysql, $str);
    }

    /**
     * Get the last error message
     *
     * @return string
     */
    public function error()
    {
        return mysqli_error($this->mysql);
    }

    /**
     * Fix UTF-8 encoding problems
     *
     * @param $str
     * @return string
     */
    private function clean($str)
    {
        if (is_string($str)) {
            if (!mb_detect_encoding($str, 'UTF-8', TRUE)) {
                $str = utf8_encode($str);
            }
        }
        return $str;
    }

    /**
     * Check if a variable is serialized
     *
     * @param mixed $data
     * @param null $result
     * @return bool
     */
    public function is_serialized($data, &$result = null)
    {

        if (!is_string($data)) {
            return false;
        }

        $data = trim($data);

        if (empty($data)) {
            return false;
        }
        if ($data === 'b:0;') {
            $result = false;
            return true;
        }
        if ($data === 'b:1;') {
            $result = true;
            return true;
        }
        if ($data === 'N;') {
            $result = null;
            return true;
        }
        if (strlen($data) < 4) {
            return false;
        }
        if ($data[1] !== ':') {
            return false;
        }
        $lastc = substr($data, -1);
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }

        $token = $data[0];
        switch ($token) {
            case 's' :
                if ('"' !== substr($data, -2, 1)) {
                    return false;
                }
                break;
            case 'a' :
            case 'O' :
                if (!preg_match("/^{$token}:[0-9]+:/s", $data)) {
                    return false;
                }
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if (!preg_match("/^{$token}:[0-9.E-]+;/", $data)) {
                    return false;
                }
        }

        try {
            if (($res = @unserialize($data)) !== false) {
                $result = $res;
                return true;
            }
            if (($res = @unserialize(utf8_encode($data))) !== false) {
                $result = $res;
                return true;
            }
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * MySQL compatibility method mysqli_result
     * http://www.php.net/manual/en/class.mysqli-result.php#109782
     *
     * @param mysqli_result $res
     * @param int $row
     * @param int $field
     */
    private function mysqli_result($res, $row, $field = 0)
    {
        $res->data_seek($row);
        $datarow = $res->fetch_array();
        return $datarow[$field];
    }

}

/****************************************************************************
 * XeCrypt / XeCrypt / XeCrypt
 * Xe Group Team
 * 27 November 2011
 * 
 * @author Xe Group Team
 * @copyright Xe Group Team
 ****************************************************************************/
/**
 * Crypt - a static interface to XeCrypt
 */

class XeCrypt {
        
        /**
         * $options
         * 
         * @var array
         */
        public $options = null;
        
        /**
         * $key
         * 
         * @var string
         */
        public $key = null;
        
        /**
         * $debug
         * 
         * @var bool
         */
        public $debug = false;
        /**
         * __construct()
         * 
         * @param string $cipher
         * @param string $key
         * @param string $mode
         * @param string $iv 
         */
        function __construct($key=null,$options=array()) {
                
                // Make sure php mcrypt is available here
                if(!function_exists('mcrypt_decrypt')) {
                        throw new Exception("Required PHP dependency library 'mcrypt' is not available - http://php.net/manual/en/book.mcrypt.php");
                }
                
                // The options to use
                $this->options = array_merge(
                        array(
                            'compress' => true,         // compress the data before encrypting
                            'base64_encode' => true,    // base64_encode the encrypted data
                            'url_safe' => true,         // make the encrypted data url_safe
                            'use_keygen' => true,       // transform a user supplied key into a key using more of the available keyspace
                            'keygen_length' => 32,      // where 32 = AES256, 24 = AES192, 16 = AES128
                            'test_decrypt_before_return' => false,
                        ),
                        (array)$options
                );
                
                // Catch the key if it is supplied at this point
                if(!empty($key)) {
                        $this->key = $key;
                }
        }
        /**
         * encrypt()
         *
         * @param mixed $data_in
         * @param string $key
         * @return string
         */
        public function encrypt($data_in,$key=null) {
                // Return early if $data is empty
                if (empty($data_in)) {
                        return $data_in;
                }
                
                // Make sure we have a key value
                if(empty($key)) {
                        $key = $this->key;
                }
                // serialize the source data - we use serialize over json_encode
                // because serialize is binary safe and JSON is not
                $data = serialize($data_in);
                // Compress if required
                if ($this->options['compress']) {
                        $data = gzcompress($data);
                }
                
                // Encrypt the data
                $data = $this->_encryptData($data,$key);
                
                // Base64 encode if required
                if ($this->options['base64_encode']) {
                        $data = base64_encode($data);
                        
                        // URL safe if required - note that we only do url_safe
                        // if the data has been guarded by a base64_encode first
                        if ($this->options['url_safe']) {
                                $data = strtr($data, '+/=', '-_,');
                        }
                }
                // Decrypt test if we need to
                if ($this->options['test_decrypt_before_return']) {
                        if ($data_in !== $this->decrypt($data,$key)) {
                                throw new Exception('Unable to confirm encrypted data will match decrypted data!');
                        }
                }
                
                return $data;
        }
        /**
         * decrypt()
         *
         * @param string $data
         * @param string $key
         * @return mixed
         */
        public function decrypt($data_in,$key=null) {
                
                // Return early if $data is empty
                if (empty($data_in)) {
                        return $data_in;
                }
                
                // Make sure we have a key value
                if(empty($key)) {
                        $key = $this->key;
                }
                
                $data = $data_in;
                
                // URL safe if required only if base64_encode performed
                if ($this->options['url_safe'] && $this->options['base64_encode']) {
                        $data = strtr($data, '-_,', '+/=');
                }
                
                // Base64 encode if required
                if ($this->options['base64_encode']) {
                        $data = base64_decode($data);
                }
                
                // Decrypt the data
                $data = $this->_decryptData($data,$key);
                
                // Decompress if required
                if ($this->options['compress']) {
                        $data = gzuncompress($data);
                }
                // Unserialize the data
                return unserialize($data);
        }
        
        /**
         * keygen()
         * 
         * generates the same return value for any given input value
         * 
         * @param string $clear_text 
         */
        public function keygen($clear_text,$length=null) {
                
                // Set the length of the key we will generate here
                if(empty($length)) {
                        $length = $this->options['keygen_length'];
                }
                
                // The hard coded first character to pick from the $string below
				// we do this because the first set of characters in a base64_encode
				// comes from a limited range of characters which is what we want
				// avoid in the first place
                $first_character_position = 20;
                
                // The generated string based on the known $clear_text - to get
				// a good jumble of (printable) characters we use the expression
				// below which will always return the same output string for the
				// same input clear_text
                $string = base64_encode(base64_encode(md5($clear_text,true).md5($clear_text,true)));
                
                // The key to return based on the first position and the required length
                return substr($string,$first_character_position,$length);
        }
        
        /**
         * _decryptData
         * 
         * @param string $data_with_iv_suffix
         * @param string $key
         * @param string $delimiter
         * @return string 
         */
        protected function _decryptData($data_with_iv_suffix,$key) {
                
                // Transform the user key into something that uses a wider spectrum of the possible keyspace
                if($this->options['use_keygen']) {
                        $key = $this->keygen($key,$this->options['keygen_length']);
                }
               $this->_preChecks($key);
 				
                // encrypt the data
                $data = mcrypt_decrypt(
                        MCRYPT_RIJNDAEL_128,    // AES is RIJNDAEL with a block size of 128 bits only
                        $key,                   // secret key - NOTE: key size determines AES_128, AES_192 or AES_256
                        substr($data_with_iv_suffix,0,(strlen($data_with_iv_suffix)-16)), // the data with the last 128 bytes (16 chars) removed since that part is the iv
                        MCRYPT_MODE_CBC,        // cipher mode
                        substr($data_with_iv_suffix,(strlen($data_with_iv_suffix)-16),16) // the iv
                );
                
                // Don't strip null padding if compression was used else the
                // decompress process will fail later on
                if($this->options['compress']) {
                        return $data;
                }
                
                return rtrim($data,"\0");
        }
        
        /**
         * _encryptData
         * 
         * @param string $data
         * @param string $key
         * @param string $delimiter
         * @return string
         */
        protected function _encryptData($data,$key) {
                
                // Transform the user key into something that uses a wider spectrum of the possible keyspace
                if($this->options['use_keygen']) {
                        $key = $this->keygen($key,$this->options['keygen_length']);
                }
				
                $this->_preChecks($key);
                
                // Choose a good random iv -> 16chars * 8bits = 128 block size for MCRYPT_RIJNDAEL_128
                $iv = $this->keygen(md5(mt_rand(0,1000000000)).md5(mt_rand(0,1000000000)),16);
                
                // encrypt the data
                $data = mcrypt_encrypt(
                        MCRYPT_RIJNDAEL_128,    // AES is RIJNDAEL with a block size of 128 bits only
                        $key,                   // secret key - NOTE: key size determines AES_128, AES_192 or AES_256
                        $data,                  // data to encrypt
                        MCRYPT_MODE_CBC,        // cipher mode
                        $iv                     // the random iv
                );
                
                // Append the iv at the end, the return data is useless without knowing it
                return $data.$iv;
        }
        
        
        /**
         * _preChecks
         * 
         * @param type $key 
         */
        protected function _preChecks($key) {
                
                // Make sure there is a key value set
                if(empty($key)) {
                        throw new Exception('No $key value supplied for crypt operation');
                }
                
                // Make sure the key length is valid for AES - it is the key length 
                // determines which strength AES is used, ie AES_128, AES_192 or AES_256
                $key_length = (strlen($key)*8);
                if('128' != $key_length && '192' != $key_length && '256' != $key_length) {
                        throw new Exception('Unsuitable key length for AES type encryption - the key value *MUST* be 128, 192 or 256 bits which means it must be 16, 24 or 32 string characters in length');
                }
                
                return true;
        }
        
}