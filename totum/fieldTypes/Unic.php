<?php
/**
 * Created by PhpStorm.
 * User: tatiana
 * Date: 25.08.17
 * Time: 13:03
 */

namespace totum\fieldTypes;

use totum\common\criticalErrorException;
use totum\common\errorException;
use totum\common\Field;
use totum\common\Lang\RU;

class Unic extends Field
{
    protected function checkValByType(&$val, $row, $isCheck = false)
    {
        if (!$isCheck && !is_null($val) && $val !== '') {
            $where = [
                ['field' => $this->data['name'], 'operator' => '=', 'value' => $val]
            ];
            if ($row['id'] ?? null) {
                $where[] = ['field' => 'id', 'operator' => '!=', 'value' => $row['id']];
            }

            if ($id_duble = $this->table->getByParams(
                ['field' => 'id', 'where' => $where]
            )) {
                errorException::criticalException(
                    $this->translate('The value must be unique. Duplication in rows: [[%s - %s]]',
                        [$id_duble, $row['id']]),
                    $this->table
                );
            }
        }
    }
}
