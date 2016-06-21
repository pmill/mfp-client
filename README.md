PHP MyFitnessPal Client
=======================

Introduction
------------

This package contains a PHP client for MyFitnessPal.

The following features are currently supported:

*   Current Weight
*   Historical Weight

Usage
-----

The following example shows how to retrieve your current weight.

    $client = new \pmill\MFP\Client();
    $client->setCredentials($username, $password);
    $currentWeight = $client->getCurrentWeight();

A more detail example is available in the examples directory.


Version History
---------------

0.1.0 (20/06/2016)

*   Get current weight
*   Get historical weight


Copyright and License
---------------------

pmill/mfp-client
Copyright (c) 2016 pmill (dev.pmill@gmail.com) 
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are
met:

*   Redistributions of source code must retain the above copyright 
    notice, this list of conditions and the following disclaimer.

*   Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in the
    documentation and/or other materials provided with the 
    distribution.

This software is provided by the copyright holders and contributors "as
is" and any express or implied warranties, including, but not limited
to, the implied warranties of merchantability and fitness for a
particular purpose are disclaimed. In no event shall the copyright owner
or contributors be liable for any direct, indirect, incidental, special,
exemplary, or consequential damages (including, but not limited to,
procurement of substitute goods or services; loss of use, data, or
profits; or business interruption) however caused and on any theory of
liability, whether in contract, strict liability, or tort (including
negligence or otherwise) arising in any way out of the use of this
software, even if advised of the possibility of such damage.
