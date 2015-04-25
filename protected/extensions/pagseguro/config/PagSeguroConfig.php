<?php
/**
 * 2007-2014 [PagSeguro Internet Ltda.]
 *
 * NOTICE OF LICENSE
 *
 *Licensed under the Apache License, Version 2.0 (the "License");
 *you may not use this file except in compliance with the License.
 *You may obtain a copy of the License at
 *
 *http://www.apache.org/licenses/LICENSE-2.0
 *
 *Unless required by applicable law or agreed to in writing, software
 *distributed under the License is distributed on an "AS IS" BASIS,
 *WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *See the License for the specific language governing permissions and
 *limitations under the License.
 *
 *  @author    PagSeguro Internet Ltda.
 *  @copyright 2007-2014 PagSeguro Internet Ltda.
 *  @license   http://www.apache.org/licenses/LICENSE-2.0
 */

$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = "production"; // production, sandbox

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = "luciano.bapo@gmail.com";
$PagSeguroConfig['credentials']['token']['production'] = "4C7C3DD4BC8B49D5A4193AC6A254E407";
$PagSeguroConfig['credentials']['token']['sandbox'] = "A11120C89C4B4DEA97BBCDDBF930B567";

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = true;
// Informe o path completo (relativo ao path da lib) para o arquivo, ex.: ../PagSeguroLibrary/logs.txt
$PagSeguroConfig['log']['fileLocation'] = $_SERVER['DOCUMENT_ROOT'].'/protected/data/pagseguro_logs.txt';
