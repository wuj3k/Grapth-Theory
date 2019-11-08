<?php

class Sorter
{
    public function mergeSort(array $data): array
    {
        $counter = count($data);
        if($counter == 1) {
            return $data;
        }
        else{
            $middle = (int)($counter / 2);
            $right = array_slice($data, $middle, $counter - $middle);
            $left = array_slice($data, 0, $middle);
            $left = $this->mergeSort($left);
            $right = $this->mergeSort($right);
            return $this->merge($left , $right);
        }
    }

    private function merge(array $left , array $right): array
    {
        $result = [];
        while (count($left) > 0 && count($right) > 0){
            if($left[0] > $right[0]){
                $result[] = $right[0];
                $right = array_slice($right , 1);
            }else{
                $result[] = $left[0];
                $left = array_slice($left, 1);
            }
        }
        while (count($left) > 0){
            $result[] = $left[0];
            $left = array_slice($left, 1);
        }
        while (count($right) > 0){
            $result[] = $right[0];
            $right = array_slice($right, 1);
        }
        return $result;
    }
}