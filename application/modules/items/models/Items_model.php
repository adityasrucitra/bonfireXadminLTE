<?php defined('BASEPATH') || exit('No direct script access allowed');

class Items_model extends MY_Model
{
    protected $table_name   = 'bf_posts';
    protected $key          = 'id';
    protected $set_created  = true;
    protected $set_modified = true;
    protected $soft_deletes = true;
    protected $date_format  = 'datetime';
}