# Fulll_test

To start the project :
```
$ git clone git@github.com:omarghamraoui/Fulll_test.git
$ cd docker
$ make start
```

To execute Behat tests :
```
$ cd docker
$ make behat
```

#### I use PHPStan: because it detects errors in codebase without running the code, improving reliability and maintainability
To run phpstan :
```
$ cd docker
$ make phpstan
```
#### I use PHPCS: because it checks that code meets set standards such as PSR-1/PSR-2, improving clarity and uniformity for teams.
To run phpcs :
```
$ cd docker
$ make phpcs
```


## CI/CD
- Create workflow files in .github/workflows/ example => ci-cd.yml
- Specify when the pipeline should run: push, pull request, or schedule.
- Set up jobs => name and action for each job.
- Deploy on Staging or main

###### NOTE : this is an example file for CI/CD 