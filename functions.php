<?php
    function convertNumberToText($input)
    {
        $response = [
            'success' => false,
            'message' => ''
        ];

        $numberIndexToChars = [ " ", "&’(", "ABC", "DEF", "GHI", "JKL", "MNO", "PQRS", "TUV", "WXYZ"];
        $validChars = [
            '1','2','3',
            '4','5','6',
            '7','8','9',
            '*','0',' ',
        ];

        $S = $input;

        if(! is_string($S)){
            $response['message'] = 'Input must be a string.';
           return $response;
        }

        if(substr($S, -1) === '#'){
            $S = substr($S, 0, strlen($S) - 1);
        }

        $inputStringArray = str_split($S);

        $outputStringArray = [];
        $i = 0;

        while($i < count($inputStringArray)){
            if (! in_array($inputStringArray[$i], $validChars))
            {
                $i++;
                continue;
            }

            // Stores the number of
            // continuous clicks
            $count = 0;

            if($inputStringArray[$i] !== '0'){
                while ($i + 1 < count($inputStringArray) && $inputStringArray[$i] === $inputStringArray[$i + 1] && $inputStringArray[$i + 1] != '*')
                {
                    $currentChar = $inputStringArray[$i];
                    if(isset($numberIndexToChars[$currentChar])){
                        if($count === strlen($numberIndexToChars[$currentChar]) - 1){
                            break;
                        }
                    }

                    $count++;
                    $i++;

                    // Handle the end condition
                    if ($i === count($inputStringArray)){
                        break;
                    }
                }
            }

            if (intval($inputStringArray[$i]) > 0 && isset($numberIndexToChars[$inputStringArray[$i]]))
            {
                $outputStringArray[] = $numberIndexToChars[$inputStringArray[$i]][$count % strlen($numberIndexToChars[$inputStringArray[$i]])];
            } else if ($inputStringArray[$i] === '*')
            {
                $outputStringArray[] = '*';
            }

            $i++;
        }

        $response['success'] = true;
        $response['input'] = $input;
        $response['data'] = trim(implode('', useStarAsBackspace($outputStringArray)));

        return $response;
    }

    /**
     * If there is a *, use it to remove the character before it
     * @param $inputArray
     * @return array
     */
    function useStarAsBackspace($inputArray){
        $elemsToDelete = 0;
        $finalOutput = [];
        $outputStringArray = array_reverse($inputArray);

        foreach($outputStringArray as $i => $s){
            if($s !=='*' && $elemsToDelete === 0){
                $finalOutput[] = $s;
            }

            if($s === '*'){
                $elemsToDelete += 1;
            }
            else if($elemsToDelete > 0){
                $elemsToDelete -= 1;
            }
        }

        return array_reverse($finalOutput);
    }
