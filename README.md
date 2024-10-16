# PHP-JWTManager

## ItsMeZmpfa PHP-JWT Manager
PHP-JWTManager is a PHP package for build Encoding, Decoding, verifying and validating JSON WEB Tokens.

- Supported algorithms:
    - HMAC: HS512

- Supported Features:
    - Built-in and custom validations
    - Multiple key and kid header handler

## Getting started

## Notes

The goal of this project is to create a JWTManager that being lightweight.

## Requirements
- PHP 8.0 or greater

## Features
- Supported algorithms
  - HMAC: HS512
- Built-in and custom validations
- Multiple key and kid Header Handler
- Encoding
- Decoding
- Verifying

## Future Feature Implementation Example
- More Supported algorithms
- Make JWTManager user-friendly

## Installation

## Configuration
Create a new .env file and place it in your root folder. This will be the file where you define the Secret Key

### Warning: ALWAYS SET YOUR SECRET KEY in the .env for security purpose

## Quick Start
Here's an example demonstrating how to generate a JWT and parse it using the using HS512 algorithm

Example .env File:
```
Example_KEY="TESTSECRETKEY"
```
Example use Case:
```
<?php
use Demo\ZmpfaRouter\ZmpfaRouter;

$jwt = TestJWTManager::generateJWT(['id' => 13, 'is-admin' => true]);

print_r($jwt); // "abc.123.xyz"

 $claims = TestJWTManager::parserJWT($jwt);
 
 print_r($claims); // ['id' => 13, 'is-admin' => true]
```

## HMAC Algorithms

HMAC algorithms rely on symmetric keys, allowing a single key to encode (sign) and decode (verify) JWTs. The PHP-JWT package supports HS512 HMAC algorithms. The example above showcases the utilization of an HMAC algorithm to both sign and verify a JWT.

## Validation
By default, the package validates certain public claims if present (using DefaultValidator), and parses the claims.
## Rules

Validators rely on Rules to validate claims, with each Rule specifying acceptable values for a claim.



## Error Handling

- Encoding:
  - InvalidKeyException when the provided key is not valid.
  - JsonEncodingException when cannot convert the provided claims to JSON.
  - SigningException when cannot sign the token using the provided signer or key.
- Decoding:
  - InvalidTokenException when the JWT format is not valid (for example, it has no payload).
  - InvalidSignatureException when the JWT signature is not valid.
  - JsonDecodingException when the JSON extracted from JWT is not valid.
  - ValidationException when at least one of the validation rules fails.
- Finding Verifier:
  - NoKidException when there is no kid in the token header.
  - VerifierNotFoundException when no key/verifier matches the kid in the token header.

All of the exceptions mentioned are subclasses of the BaseException exception. By catching BaseException, you can handle all these cases collectively instead of catching each one individually.
