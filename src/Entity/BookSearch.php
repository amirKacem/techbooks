<?php
namespace App\Entity;

class BookSearch{
    
    private $by_category;

    private $by_keyword;

    private $by_author;

    /**
     * Get the value of by_category
     */ 
    public function getByCategory()
    {
        return $this->by_category;
    }

    /**
     * Set the value of by_category
     *
     * @return  self
     */ 
    public function setByCategory($by_category)
    {
        $this->by_category = $by_category;

        return $this;
    }

    /**
     * Get the value of by_keyword
     */ 
    public function getByKeyword()
    {
        return $this->by_keyword;
    }

    /**
     * Set the value of by_keyword
     *
     * @return  self
     */ 
    public function setByKeyword($by_keyword)
    {
        $this->by_keyword = $by_keyword;

        return $this;
    }

    /**
     * Get the value of by_author
     */ 
    public function getByAuthor()
    {
        return $this->by_author;
    }

    /**
     * Set the value of by_author
     *
     * @return  self
     */ 
    public function setByAuthor($by_author)
    {
        $this->by_author = $by_author;

        return $this;
    }

}