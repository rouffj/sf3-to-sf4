Legacy Hangman on Symfony 3.4
=============================

**WARNING**: Running with PHP 7 will cause some annotation parsing to fail.
`IsGranted` and `Cache` are defined as `todo` in controller classes.

Install
-------

Use the base `main` branch to clone the project and see the git log:

```bash
git clone ...
cd ...
git log
```

Install dependencies and run the tests:

```bash
composer install
vendor/bin/simple-phpunit
```

You should see the following result:

```
PHPUnit 6.5.14 by Sebastian Bergmann and contributors.

Testing Project Test Suite
................                                                  16 / 16 (100%)

Time: 2.66 seconds, Memory: 50.50MB

OK (16 tests, 55 assertions)

Unsilenced deprecation notices (2)

  2x: "continue" targeting switch is equivalent to "break". Did you mean to use "continue 2"?
    2x in GameControllerTest::testReset from Tests\AppBundle\Controller

Remaining deprecation notices (6)

  1x: Not quoting the scalar "%kernel.project_dir%/app/Resources/data/test.txt" starting with the "%" indicator character is deprecated since Symfony 3.1 and will throw a ParseException in 4.0 in "/Users/heah/Sites/hangman/app/config/config_test.yml" on line 6.
    1x in GameControllerTest::testReset from Tests\AppBundle\Controller

  1x: Not quoting the scalar "%kernel.project_dir%/app/Resources/data/words.txt" starting with the "%" indicator character is deprecated since Symfony 3.1 and will throw a ParseException in 4.0 in "/Users/heah/Sites/hangman/app/config/services.yml" on line 8.
    1x in GameControllerTest::testReset from Tests\AppBundle\Controller

  1x: Not quoting the scalar "%kernel.project_dir%/app/Resources/data/words.xml" starting with the "%" indicator character is deprecated since Symfony 3.1 and will throw a ParseException in 4.0 in "/Users/heah/Sites/hangman/app/config/services.yml" on line 9.
    1x in GameControllerTest::testReset from Tests\AppBundle\Controller

  1x: The "framework.session.use_strict_mode" option is enabled by default and deprecated since Symfony 3.4. It will be always enabled in 4.0.
    1x in GameControllerTest::testReset from Tests\AppBundle\Controller

  1x: Not setting "logout_on_user_change" to true on firewall "main" is deprecated as of 3.4, it will always be true in 4.0.
    1x in GameControllerTest::testReset from Tests\AppBundle\Controller

  1x: Call Form::isValid() with an unsubmitted form is deprecated since Symfony 3.2 and will throw an exception in 4.0. Use Form::isSubmitted() before Form::isValid() instead.
    1x in AppKernelTest::testRouting from Tests
```

Workshop
--------

The workshop should last a day to migrate to 4.4 with a Flex architecture.

Start by downloading an archive of the `main` branch.
Read [https://github.com/symfony/symfony/blob/4.4/UPGRADE-4.0.md]() to trainees.
Follow the steps of the `trainer-guide` branch:
