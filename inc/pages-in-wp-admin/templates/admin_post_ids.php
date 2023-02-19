<p>
  <i>
    ID всегда указано в URL страницы.<br>
    Чтобы его извлечь нужно зайти на нужную страницу и скопировать число из переменной "post":<br>
    Пример: https://domen/wp-admin/post.php?<b>post=<span style="color:red">10</span></b>&action=edit
  </i>
</p>


<br>

<div style="display:flex; flex-direction: row; flex-wrap: wrap;">
  <form method="post" action="options.php" style="width:50%;">
    <div style="padding:4px">
      <h2>ID страниц</h2>
      <?php
        settings_fields( POST_IDS__OPTION_GROUP/* settings["option_group"] */ );
        do_settings_fields( POST_IDS_SLUG, POST_IDS__SECTION_ID/* fields["page"] */ );
        submit_button('Сохарнить изменения');
      ?>
      <hr>
    </div>
  </form>

  <form method="post" action="options.php" style="width:50%;">
    <div style="padding:4px">
      <h2>ID постов</h2>
      <?php
        settings_fields( POST_IDS__OPTION_GROUP_2/* settings["option_group"] */ );
        do_settings_fields( POST_IDS_SLUG, POST_IDS__SECTION_ID_2/* fields["page"] */ );
        submit_button('Сохарнить изменения');
      ?>
      <hr>
    </div>
  </form>

  <form method="post" action="options.php" style="width:50%;">
    <div style="padding:4px">
      <h2>ID "целевых" страниц</h2>
      <?php
        settings_fields( POST_IDS__OPTION_GROUP_4/* settings["option_group"] */ );
        do_settings_fields( POST_IDS_SLUG, POST_IDS__SECTION_ID_4/* fields["page"] */ );
        submit_button('Сохарнить изменения');
      ?>
      <hr>
    </div>
  </form>

  <form method="post" action="options.php" style="width:50%;">
    <div style="padding:4px">
      <h2>ID таксономий (категории/теги)</h2>
      <?php
        settings_fields( TERM_IDS__OPTION_GROUP/* settings["option_group"] */ );
        do_settings_fields( POST_IDS_SLUG, TERM_IDS__SECTION/* fields["page"] */ );
        submit_button('Сохарнить изменения');
      ?>
      <hr>
    </div>
  </form>

  <form method="post" action="options.php" style="width:50%;">
    <div style="padding:4px">
      <h2>ID форм</h2>
      <?php
        settings_fields( FORM_POST_IDS__OPTION_GROUP_3/* settings["option_group"] */ );
        do_settings_fields( POST_IDS_SLUG, FORM_POST_IDS__SECTION_ID_3/* fields["page"] */ );
        submit_button('Сохарнить изменения');
      ?>
      <hr>
    </div>
  </form>
</div>

