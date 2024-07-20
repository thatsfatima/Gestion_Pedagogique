<?php
namespace Apps\Core;

class Data {
    public $data;
    public $pagination;

    public function __construct($data) {
        $this->data = $data;
    }

    public function paginate($current, $nbitems) {
        $current = intval($current);
        $nbpages = ceil(count($this->data) / $nbitems);
        $start = ($current - 1) * $nbitems;

        $prev = $current - 1;
        if ($prev < 1) {
            $prev = 1;
        }

        $next = $current + 1;
        if ($next > $nbpages) {
            $next = $nbpages;
        }

        return [
            'current' => $current,
            'nbpages' => $nbpages,
           'start' => $start,
            'pre' => $prev,
            'suiv' => $next
        ];
    }

    /* public function button($button, $curent) {
        if ($button === "pre") {
            return $curre
        }
    } */

    public function show($nbitems, $current) {
        $pagination = $this->paginate($current, $nbitems);
        $data = array_slice($this->data, $pagination['start'], $nbitems);

        return [
            'data' => $data,
            'pagination' => $pagination
        ];
    }

}
?>