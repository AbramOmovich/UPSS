<?php

namespace UPSS\Postprocessing;

use UPSS\Preprocessing\EntityCollection\ICollection;

interface IResponseHandler
{
    public function send() : string;

    public function setData(ICollection $data);
}