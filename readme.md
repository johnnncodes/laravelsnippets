## LaravelSnippets.com website

Live site - http://laravelsnippets.com/

Twitter - https://twitter.com/laravelsnippets

Facebook Page - https://www.facebook.com/LaravelSnippets

Don't forget to star this repository :) And feel free to fork it.

### Core Developers
- John Kevin M. Basco - https://twitter.com/johnkevinmbasco
- Christopher Pitt - https://twitter.com/followchrisp
- Ionut Tanasa - https://twitter.com/ionutz2k
- David Knight - https://twitter.com/davidnknight

### How to contribute?

#### Bug fixes
- Just fork the repository, apply your bug fix and send a pull request on the **development** branch.

#### Features
- File an issue on this repo with a title that looks like this: [Proposal] Admin Dashboard.
- Once the proposal is approved you can go ahead and implement your proposal and send a pull request.

You can also contribute features by visiting the issues page on the repository, you'll see issues
tagged with "request", if you want to implement it, just leave a comment that you will implement it and
just send a pull request.

### Contributors

#### A huge thanks to these developers who contributed to the development of the site:
- Martin Dilling-Hansen [@dillinghansen](https://twitter.com/dillinghansen)
- Sercan Çakır [/mayoz](https://github.com/mayoz)
- Nico Romero Peñaredondo
- Davide Bellini [@billmn](https://twitter.com/billmn)

### Requirements

1. PHP 5.4
2. Redis

### Local Installation
See [wiki page](https://github.com/basco-johnkevin/laravelsnippets/wiki/Local-Installation)

### Running the tests

1. Create a test database and configure ```config/testing/database.php```

2. Migrate and Seed database for testing ```php artisan migrate --seed --env=testing```

3. Run ```php vendor/bin/phpunit``` in the console
