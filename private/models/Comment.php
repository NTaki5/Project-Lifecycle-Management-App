<?php

class Comment extends Model{

    public $allowedColumns = ["fk_user_id","fk_parent_id", "fk_feed_id", "comment", "likes"];

    

}