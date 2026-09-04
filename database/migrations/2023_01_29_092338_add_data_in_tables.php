<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement('INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `facebook_id`, `password`, `phone`, `address`, `city`, `state`, `zip`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
        (1, 0, "Super Admin", "admin@example.com", NULL, "$2y$10$NDJ8GvTAdoJ/uG0AQ2Y.9ucXwjy75NVf.VgFnSZDSakRRvrEyAlMq", NULL, NULL, NULL, NULL, NULL, 1, "rDWTyMV7OybRAqR2W5jCSb3a6O78yOfWbzLz1dspV6qlNoiv3IcXi9QBSxwp", NULL, NULL),
        (5, 1, "Admin", "admin@admin.com", NULL, "$2y$10$NDJ8GvTAdoJ/uG0AQ2Y.9ucXwjy75NVf.VgFnSZDSakRRvrEyAlMq", NULL, NULL, NULL, NULL, NULL, 2, "GXMRWhuf3sqeoVNTPnyEnLEhBsyP3tURLefbUIcwBRvlTDRTBMZdxuUbUl4T", NULL, NULL),
        (6, 1, "Sale Manger", "sales@manager.com", NULL, "$2y$10$NDJ8GvTAdoJ/uG0AQ2Y.9ucXwjy75NVf.VgFnSZDSakRRvrEyAlMq", NULL, NULL, NULL, NULL, NULL, 2, "qpPtzImTYQNY8ysYEjUztZn01zjsW4Qda73C68FO7QZ3qhDPDtwb9MdD9Jvw", NULL, NULL),
        (25, 2, "Brnach 2 Manager", "branch2@admin.com", NULL, "$2y$10$NDJ8GvTAdoJ/uG0AQ2Y.9ucXwjy75NVf.VgFnSZDSakRRvrEyAlMq", NULL, NULL, NULL, NULL, NULL, 3, "AruJiY7PZpVAhORzCYnA9paAsVJzaPqvycgUN2mdy4GBlwQPUymXdi1S73Zn", "2021-02-05 05:33:08", "2021-08-19 13:09:24"),
        (26, NULL, "Waitress 1", "waitress@staff.com", NULL, "$2y$10$6CwU.Mz9EPVk2ZLLezog5O8xUCNY0VBCDgAsC1u98pRXPLOW0iMY6", NULL, NULL, NULL, NULL, NULL, 3, NULL, "2021-08-20 12:08:00", "2021-08-20 12:08:00");
        ');


        DB::statement("INSERT INTO `pages` (`id`, `title`, `slug`, `image`, `body`, `parent_id`, `is_delete`) VALUES
        (1, 'Terms & Condition', 'services', '574724_page.jpg', 'Pellentesque pellentesque eget tempor tellus. Fusce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus. Fusce lacinia tempor malesuada.\r\n\r\n                            <h2>H2 Heading</h2>\r\n                            <p>Pellentesque pellentesque usce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus.  tellus eget tempor. Fusce lacinia tempor malesuada.</p>\r\n\r\n                            <h3>H3 Heading</h3>\r\n                            <p>Pellentesque tempor tellus eget pellentesque. usce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus.  Fusce lacinia tempor malesuada.</p>\r\n\r\n                            <h4>H4 Heading</h4>\r\n                            <p>Pellentesque pellentesque tempor tellus eget fermentum. usce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus. </p>\r\n\r\n                            <h5>H5 Heading</h5><div>this is a test editing </div>\r\n                            <p>Pellentesque pellentesque tempor llentesque pellentesque tempor tellus eget libero llentesque pellentesque tempor tellus eget libero tellus ementellentesque tempor tellus eget fermentum. usce lacllentesque eget tempor tellus ellenellentesque tempor tellus eget fermentum. usce lacllentesque eget tempor tellus ellenum.</p>\r\n\r\n                            <h6>H6 Heading</h6>\r\n                            <p>Pellentesque pellentesque tempor tellus eget libero</p>', 0, 0),
        (2, 'FAQ', 'faq', 'page2.jpg', '<div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span><span style=\"font-weight: bold;\"><br></span></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?<br></span></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><br></span></div><div><span style=\"font-weight: bold;\">1 : this is a question number 1</span><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><br></span></div><div><span style=\"font-weight: bold;\">1 : this is a question number 1</span><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><br></span></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><span style=\"color: rgb(103, 106, 108); font-weight: bold;\">1 : this is a question number 1</span><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><br></span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><span style=\"color: rgb(103, 106, 108); font-weight: bold;\">1 : this is a question number 1</span><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><br></span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><span style=\"color: rgb(103, 106, 108); font-weight: bold;\">1 : this is a question number 1</span><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div></span></div></span></div></span></div>', 0, 0),
        (3, 'About Us', 'about-us', 'pages/SIUkiFG8DW8gJ0ZaCPymRe4bscaJDxsDTGXOmQCk.jpg', '<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta dolorem non blanditiis ex fugiat. </p>\r\n\r\n\r\n<h2> Heading 2</h2>\r\n\r\n<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta dolorem non blanditiis ex fugiat. </p><p><br></p><h2 style=\"color: rgb(103, 106, 108);\">Heading 2</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta dolorem non blanditiis ex fugiat.</p>', 0, 0);
        ");
        DB::statement("INSERT INTO `categories` (`id`, `company_id`, `name`, `printers`, `sort`, `updated_at`, `created_at`) VALUES
        (1, NULL, 'Appetizers', NULL, 0, '2023-01-24 23:06:09', '2023-01-24 23:06:09'),
        (2, NULL, 'Seafood', NULL, 0, '2023-01-24 23:06:55', '2023-01-24 23:06:55'),
        (3, NULL, 'Rice and Noodles', NULL, 0, '2023-01-24 23:07:43', '2023-01-24 23:07:43'),
        (4, NULL, 'Soup', NULL, 0, '2023-01-24 23:08:41', '2023-01-24 23:08:41'),
        (5, NULL, 'Desserts', NULL, 0, '2023-01-24 23:09:14', '2023-01-24 23:09:14'),
        (6, NULL, 'Beverages', NULL, 0, '2023-01-24 23:09:53', '2023-01-24 23:09:53');");
        
        DB::statement("INSERT INTO `homepage` (`id`, `key`, `type`, `label`, `value`, `language`, `created_at`, `updated_at`) VALUES
        (1, 'story_title', 'text', 'Story Title', '<span>Discover</span>Our Story', NULL, NULL, '2017-09-20 16:13:04'),
        (2, 'story_desc', 'textarea', 'Story Description', 'accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.', NULL, NULL, '2017-09-20 16:13:04'),
        (3, 'menu_title', 'text', 'Menu Title', '<span>Discover</span>Our Menu', NULL, NULL, '2017-09-20 16:13:04'),
        (4, 'menu_desc', 'textarea', 'Menu Description', 'accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.', NULL, NULL, '2017-09-20 16:13:04'),
        (5, 'img_title1', 'text', 'Image Title 1', '<h2><span>We Are Sharing</span></h2>                    <h1>delicious treats</h1>', NULL, NULL, '2017-09-25 16:36:13'),
        (6, 'img_title2', 'text', 'Image Title 2', '<h2><span>The Perfect</span></h2>                    <h1>Blend</h1>', NULL, NULL, '2017-09-25 16:36:13'),
        (7, 'category', NULL, 'Home Categories', '1,2,3,4', NULL, NULL, '2023-01-25 22:18:12');
        ");


        DB::statement("INSERT INTO `sliders` (`id`, `restaurant_id`, `title`, `image`, `created_at`, `updated_at`) VALUES
        (6, NULL, 'Mouth Watering', '947370.jpg', NULL, NULL),
        (7, NULL, 'Food For You', '171155.jpg', NULL, NULL),
        (8, NULL, 'Enjoy the Taste', '953088.jpg', NULL, NULL),
        (9, NULL, 'Eat Healthy', '856611.jpg', NULL, NULL),
        (10, NULL, 'Nicely Cooked', '621866.jpg', NULL, NULL);");


        DB::statement("INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
        (1, 1),
        (5, 2),
        (6, 2),
        (25, 3),
        (26, 3);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
