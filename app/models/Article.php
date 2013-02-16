<?php

class Article extends Eloquent {

    protected $table = 'articles';

    protected $etag = false;

    public function getEtag()
    {
    	if ( $this->exists && $this->etag === false )
    	{
    		return $this->etag = md5( $this->table . $this->id . $this->updated_at );
    	}

    	return $this->etag;

    }

}