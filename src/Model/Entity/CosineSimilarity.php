<?php
declare(strict_types=1);

namespace OurSociety\Model\Entity;

class CosineSimilarity {
    public function similarity(array $arrayOfAnswers1, array $arrayOfAnswers2) {
        $s1 = [];
        $s2 = [];
        $w1 = [];
        $w2 = [];

        foreach ($arrayOfAnswers1 as $u1row) {
            array_push($s1, $u1row["answer"]);
            array_push($w1, $u1row["importance"]);
        }

        foreach ($arrayOfAnswers2 as $u2row) {
            array_push($s2, $u2row["answer"]);
            array_push($w2, $u2row["importance"]);
        }

        foreach ($s1 as $i => $s1elem) {
            $s1[$i] = $s1elem * $w1[$i];
        }

        foreach ($s2 as $i => $s2elem) {
            $s2[$i] = $s2elem * $w2[$i];
        }
        return @($this->_dotProduct($s1, $s2) / ($this->_absVector($s1) * $this->_absVector($s2)));
    }

    protected function _dotProduct(array $vec1, array $vec2) {
        $result = 0;

        foreach (array_keys($vec1) as $key1) {
            foreach (array_keys($vec2) as $key2) {
    	        if ($key1 === $key2) $result += $vec1[$key1] * $vec2[$key2];
            }
        }

        return $result;
    }

    protected function _absVector(array $vec) {
        $result = 0;

        foreach (array_values($vec) as $value) {
            $result += $value * $value;
        }

        return sqrt($result);
    }
}
