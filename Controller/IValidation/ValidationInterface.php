<?php
/**
 * Created by PhpStorm.
 * User: savero
 * Date: 5/29/2016
 * Time: 5:31 PM
 */
namespace IValidation;

interface ValidationInterface
{
    /**
     * @return array
     */
    public function getBool();

    /**
     * @param array $bool
     */
    public function setBool($bool);

    /**
     * @param $input
     * @return mixed
     */
    public function validateUsernameToDB($input);

    /**
     * @param $input
     * @return mixed
     */
    public function validatePasswordToDB($input);

    /**
     * @param $input
     * @return mixed
     */
    public function validateUsername($input);

    /**
     * @param $input
     * @param $comparable
     * @return mixed
     */
    public function validatePassword($input, $comparable);

    /**
     * @param $input
     * @return mixed
     */
    public function validateEmail($input);

    /**
     * @param $input
     * @return mixed
     */
    public function validatePhone($input);

    /**
     * @param $input
     * @return mixed
     */
    public function validateAddress($input);

}
