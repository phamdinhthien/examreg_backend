<?php
     function validateValueStudent($name, $code, $dob){
        $regexCode = '/^[0-9]{8}$/';
        $regexName = '/^[\wÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ ]+$/';
        $regexDob = '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/';
        if(preg_match($regexCode, $code) && preg_match($regexName, $name) && preg_match($regexDob, $dob)){
            return true;
        } 
        return false;
    }

