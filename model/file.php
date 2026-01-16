<?php

class File {
    public int $id = 0;
    public int $fk_uid = 0; // foreign key user id
    public string $filename = "";

    public int $tid = 0;
    public int $fk_fid = 0;
    public string $attribut = "";
    public string $value = "";
}