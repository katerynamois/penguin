<?php

// There isn't a defined way to log out of basic auth.
// But responding with a 401 unauthorized will log out in most browsers.
// This file can be called using javascript fetch, and then reload the page using javascript.

http_response_code(401);
echo 'Unauthorized access';
