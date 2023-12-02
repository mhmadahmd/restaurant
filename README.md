## About Project

Restaurant is a web application to create Menus, Categories, Sub Categories ,and Items As well as add Discount based on all the above.

## Installation

    composer install

Then

    php artisan migrate --seed

## Demo Data

After Migration with seeders you get the following users:

| Username                   | Password      | Role             |
|:---------------------------|:--------------|:-----------------|
| <admin@mail.com>           | password      | Admin            |
| <restaurantadmin@mail.com> | password      | Restaurant Admin |

- Admin Role can do the following:
  - Create \ Delete Menus
  - Create \ Delete Categories & Sub Categories to his Menus
  - Create \ Delete Items to his Menus
  - Assign Restaurant Admin to his Menu
- Restaurant Admin can do the following:
  - Add Discount to his Menus, Categories, Sub Categories, Items
