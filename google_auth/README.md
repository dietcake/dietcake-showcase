# Install

```
$ cp controllers/google_auth_controller.php YOURPROJECT/app/controllers/
$ cp models/google_auth.php YOURPROJECT/app/models/
$ cp config/google.php YOURPROJECT/app/config/
$ echo "require_once __DIR__ . '/google.php';" >> YOURPROJECT/config/core.php
$ cd YOURPROJECT
$ composer require google/apiclient
```

# File list

- controllers/google_auth_controller.php
- models/google_auth.php
- config/google.php

