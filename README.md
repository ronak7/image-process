# LARAVER 6

*Note:* Please use migration file to create database table-    *2020_05_11_025243_create_files_table.php* 

## Task: 1
In a home page you can see one input box so you can enter any number and click a button. and output will display accordingly


## Task: 2

Here I have created two APIs for upload image and delte image

### Upload 
- URL: localhost:8000/api/uploads
- Field: *image* 
- Method: *POST* 
##
- Once image upload it will converte in black and white.
- And created variation like, 1000x1000 750x750 530x530 300x300
- Save image as per variation

### Detele images and data
- URL: localhost:8000/api/delete
- Method: *POST*
#
- It will delete images and data from database
- This function will delete all images, before 30 mins from *created_at* 
- You can use it with cron

