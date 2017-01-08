<?php

  class ConfigException extends \Exception
  {
  }

  class Config
  {
    private $f;
    public function __construct($filename, $loadFromFile = false)
    {
      if(!($loadFromFile))
      {
        $this->f           = $filename;
        $this->{$filename} = new stdClass();
        return $this->{$filename};
      }
      $this->f           = $filename;
      $this->{$filename} = new stdClass();
      return $this->getConfig();
    }

    public function save()
    {
      if(isset($this->{$this->f}))
      {
        @unlink($this->f);
        @touch($this->f);
        foreach($this->{$this->f} as $k => $v)
        {
          if(end($this->{$this->f}) === $v)
          {
            if(is_array($v))
            {
              foreach($v as $key => $value)
              {
                if(end($v) === $value)
                {
                  file_put_contents($this->f, $key . ': ' . $value, FILE_APPEND);
                }
                else
                {
                  file_put_contents($this->f, $key . ': ' . $value . "\n", FILE_APPEND);
                }
              }
            }
            else
            {
              file_put_contents($this->f, $k . ': ' . $v, FILE_APPEND);
            }
          }
          else
          {
            file_put_contents($this->f, $k . ': ' . $v . "\n", FILE_APPEND);
          }
        }
        return true;
      }
      throw new \ConfigException('No config found, use the Config constructor.');
    }

    private function getConfig()
    {
      $f = file($this->f);
      foreach($f as $k)
      {
        $l = explode(':', $k);
        $this->{$this->f}->{$l[0]} = $l[1];
      }
    }

    public function set($key, $value)
    {
      if(isset($this->{$this->f}))
      {
        $this->{$this->f}->{$key} = $value;
        return true;
      }
      throw new \ConfigException('No config found, use the Config constructor.');
    }

    public function setNested($array, $key, $value)
    {
      if(isset($this->{$this->f}))
      {
        if(isset($this->{$this->f}->{$array}))
        {
          if(is_array($this->{$this->f}->{$array}))
          {
            $this->{$this->f}->{$array}[$key] = $value;
            return true;
          }
          throw new \ConfigException($array . ' key must be of type array.');
        }
        throw new \ConfigException($array . ' key does not exists.');
      }
      throw new \ConfigException('No config found, use the Config constructor.');
    }

    public function get($key)
    {
      if(isset($this->{$this->f}))
      {
        return (isset($this->{$this->f}->{$key}) ? $this->{$this->f}->{$key} : false);
        return true;
      }
      throw new \ConfigException('No config found, use the Config constructor.');
    }

    public function getNested($array, $key)
    {
      if(isset($this->{$this->f}))
      {
        if(isset($this->{$this->f}->{$array}))
        {
          if(is_array($this->{$this->f}->{$array}))
          {
            return (isset($this->{$this->f}->{$array}[$key]) ? $this->{$this->f}->{$array}[$key] : false);
          }
          throw new \ConfigException($array . ' key must be of type array.');
        }
        throw new \ConfigException($array . ' key does not exists.');
      }
      throw new \ConfigException('No config found, use the Config constructor.');
    }
  }
