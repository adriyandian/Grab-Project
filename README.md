# Image Uploader

This is a very simple app that allows you to do a couple of things, Sign in/up
and view your dashboard.

Your Dashboard will contain all your photos that you have uploaded. you can then
sort the images by the following: Date, Size, Name, Tag(s).

You can then switch to a "Public Board". Here you can see images every one in the
system has updated. You can then tag the images, sort by the same: Date, Size, Name and Tag(s) as well as the user who uploaded the images.

You can upload images (up to 2 mbs in size) or "link" to images. These images are stored in a `uploads/` directory and the path is saved in the database.

Only the original user who uploaded the image can delete the image. Image duplication is determined by url before we upload the image.

If the Image is being uploaded from the desktop and not a url link, we determine based on original file name.

Upon uploading you can add a name, description and tags. Tags do not have to exist in the system. Once uploaded and saved the image will appear on your dashboard and
in the public board.

## Requirements:

PHP >=5.3
Composer
Git

## Install:

- git clone `git@github.com:AdamKyle/image_upload_app.git` to `/var/www` (or
  where ever your web server reads from)
- cd `image_upload_app/``
- `composer install`
- change `db_config_sampl.ini` to `db_config.ini` and fill in the data as you see fit.
- visit the site in your browser and have fun.

## Testing

You can run `bin/run-tests` to test the app.
