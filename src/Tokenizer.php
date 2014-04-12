<?php

/**
 * Class Tokenizer
 *
 * @author Tom Walder <tom@docnet.nu>
 */
class Tokenizer {

    /**
     * Tokenize input into edge n-grams
     *
     * e.g. tree becomes "t tr tre"
     *
     * @param $str
     * @return string
     */
    public function edgeNGram($str) {
        $str_ngrams = '';
        $arr_words = explode(' ', $str);
        foreach($arr_words as $str_word) {
            $int_len = strlen($str_word);
            for($int_size = 1; $int_size < $int_len; $int_size++) {
                $str_ngrams .= substr($str_word, 0, $int_size) . ' ';
            }
        }
        return $str_ngrams;
    }

}

$obj_t = new Tokenizer();

foreach(['tree', 'the quick brown fox jumped over the lazy dog'] as $str_test) {
    echo "[{$str_test}] => " . $obj_t->edgeNGram($str_test) . "\n";
}