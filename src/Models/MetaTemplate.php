<?php

namespace PyrobyteWeb\MetaTemplates\Models;

class MetaTemplate extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = ['id'];

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRouteName()
    {
        return $this->route_name;
    }

    /**
     * @param mixed $route_name
     * @return self
     */
    public function setRouteName($route_name): self
    {
        $this->route_name = $route_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return self
     */
    public function setActive($active): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * @param mixed $meta_title
     * @return self
     */
    public function setMetaTitle($meta_title): self
    {
        $this->meta_title = $meta_title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * @param mixed $meta_keywords
     * @return self
     */
    public function setMetaKeywords($meta_keywords): self
    {
        $this->meta_keywords = $meta_keywords;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * @param mixed $meta_description
     * @return self
     */
    public function setMetaDescription($meta_description): self
    {
        $this->meta_description = $meta_description;
        return $this;
    }

    public static function getTemplate(string $routeName):? MetaTemplate
    {
        return self::where('route_name', $routeName)
            ->first();
    }
}
