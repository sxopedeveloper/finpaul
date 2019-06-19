<?php
/**
 * UpdateCustomerRequest
 *
 * PHP version 5
 *
 * @category Class
 * @package  SquareConnect
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
/**
 *  Copyright 2016 Square, Inc.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * UpdateCustomerRequest Class Doc Comment
 *
 * @category    Class
 * @description Defines the body parameters that can be provided in a request to the [UpdateCustomer](#endpoint-updatecustomer) endpoint.
 * @package     SquareConnect
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class UpdateCustomerRequest implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'given_name' => 'string',
        'family_name' => 'string',
        'company_name' => 'string',
        'nickname' => 'string',
        'email_address' => 'string',
        'address' => '\SquareConnect\Model\Address',
        'phone_number' => 'string',
        'reference_id' => 'string',
        'note' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'given_name' => 'given_name',
        'family_name' => 'family_name',
        'company_name' => 'company_name',
        'nickname' => 'nickname',
        'email_address' => 'email_address',
        'address' => 'address',
        'phone_number' => 'phone_number',
        'reference_id' => 'reference_id',
        'note' => 'note'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'given_name' => 'setGivenName',
        'family_name' => 'setFamilyName',
        'company_name' => 'setCompanyName',
        'nickname' => 'setNickname',
        'email_address' => 'setEmailAddress',
        'address' => 'setAddress',
        'phone_number' => 'setPhoneNumber',
        'reference_id' => 'setReferenceId',
        'note' => 'setNote'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'given_name' => 'getGivenName',
        'family_name' => 'getFamilyName',
        'company_name' => 'getCompanyName',
        'nickname' => 'getNickname',
        'email_address' => 'getEmailAddress',
        'address' => 'getAddress',
        'phone_number' => 'getPhoneNumber',
        'reference_id' => 'getReferenceId',
        'note' => 'getNote'
    );
  
    /**
      * $given_name The customer's given (i.e., first) name.
      * @var string
      */
    protected $given_name;
    /**
      * $family_name The customer's family (i.e., last) name.
      * @var string
      */
    protected $family_name;
    /**
      * $company_name The name of the customer's company.
      * @var string
      */
    protected $company_name;
    /**
      * $nickname A nickname for the customer.
      * @var string
      */
    protected $nickname;
    /**
      * $email_address The customer's email address.
      * @var string
      */
    protected $email_address;
    /**
      * $address The customer's physical address.
      * @var \SquareConnect\Model\Address
      */
    protected $address;
    /**
      * $phone_number The customer's phone number.
      * @var string
      */
    protected $phone_number;
    /**
      * $reference_id An optional second ID you can set to associate the customer with an entity in another system.
      * @var string
      */
    protected $reference_id;
    /**
      * $note An optional note to associate with the customer.
      * @var string
      */
    protected $note;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            $this->given_name = $data["given_name"];
            $this->family_name = $data["family_name"];
            $this->company_name = $data["company_name"];
            $this->nickname = $data["nickname"];
            $this->email_address = $data["email_address"];
            $this->address = $data["address"];
            $this->phone_number = $data["phone_number"];
            $this->reference_id = $data["reference_id"];
            $this->note = $data["note"];
        }
    }
    /**
     * Gets given_name
     * @return string
     */
    public function getGivenName()
    {
        return $this->given_name;
    }
  
    /**
     * Sets given_name
     * @param string $given_name The customer's given (i.e., first) name.
     * @return $this
     */
    public function setGivenName($given_name)
    {
        $this->given_name = $given_name;
        return $this;
    }
    /**
     * Gets family_name
     * @return string
     */
    public function getFamilyName()
    {
        return $this->family_name;
    }
  
    /**
     * Sets family_name
     * @param string $family_name The customer's family (i.e., last) name.
     * @return $this
     */
    public function setFamilyName($family_name)
    {
        $this->family_name = $family_name;
        return $this;
    }
    /**
     * Gets company_name
     * @return string
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }
  
    /**
     * Sets company_name
     * @param string $company_name The name of the customer's company.
     * @return $this
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
        return $this;
    }
    /**
     * Gets nickname
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }
  
    /**
     * Sets nickname
     * @param string $nickname A nickname for the customer.
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }
    /**
     * Gets email_address
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->email_address;
    }
  
    /**
     * Sets email_address
     * @param string $email_address The customer's email address.
     * @return $this
     */
    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
        return $this;
    }
    /**
     * Gets address
     * @return \SquareConnect\Model\Address
     */
    public function getAddress()
    {
        return $this->address;
    }
  
    /**
     * Sets address
     * @param \SquareConnect\Model\Address $address The customer's physical address.
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    /**
     * Gets phone_number
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }
  
    /**
     * Sets phone_number
     * @param string $phone_number The customer's phone number.
     * @return $this
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
        return $this;
    }
    /**
     * Gets reference_id
     * @return string
     */
    public function getReferenceId()
    {
        return $this->reference_id;
    }
  
    /**
     * Sets reference_id
     * @param string $reference_id An optional second ID you can set to associate the customer with an entity in another system.
     * @return $this
     */
    public function setReferenceId($reference_id)
    {
        $this->reference_id = $reference_id;
        return $this;
    }
    /**
     * Gets note
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }
  
    /**
     * Sets note
     * @param string $note An optional note to associate with the customer.
     * @return $this
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
        }
    }
}
