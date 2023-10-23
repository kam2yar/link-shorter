<?php

namespace App\Services\Validation;

use App\Services\Database\Mysql;
use PDO;
use Rakit\Validation\Rule;

class ExistRule extends Rule
{
    protected $message = ":attribute :value not exist";

    protected $fillableParams = ['table', 'column'];

    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = (new Mysql())->getConnection();
    }

    public function check($value): bool
    {
        // make sure required parameters exists
        $this->requireParameters(['table', 'column']);

        // getting parameters
        $column = $this->parameter('column');
        $table = $this->parameter('table');

        // do query
        $stmt = $this->pdo->prepare("select count(*) as count from `{$table}` where `{$column}` = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // true for valid, false for invalid
        return intval($data['count']) > 0;
    }
}