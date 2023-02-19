<h1>Данные форм</h1>
<?php if ( current_user_can('administrator') ) {  ?>

  <?php
    global $wpdb;
    $csv_list = my_custom_form_db__get_csv([
      'count' => 50,
      // 'from_post_title' => 'О компании',
      // 'from_post_id' => 1311,
      // 'from_datetime' => '2021-03-26 22:40:21',
      // 'to_datetime' => '2021-03-26 22:40:21',
    ]);
  ?>


  <form action="<?php echo esc_attr('admin-post.php'); ?>" method="post">
    <input type="hidden" name="action" value="dwl_my_custom_form_data_csv" />
    <div style="padding: 4px 0;">
      <label>Кол-во строк<input type="text" name="count" value="99999"/></label>
    </div>
    <div style="padding: 4px 0;">
      <label>from_post_id <input type="text" name="from_post_id"/></label>
      <label>from_post_title <input type="text" name="from_post_title"/></label>
    </div>
    <div style="padding: 4px 0;">
      <label>С <input type="text" name="from_datetime" placeholder="2021-03-26 00:00:00"/></label>
      <label>По <input type="text" name="to_datetime" placeholder="2021-03-29 23:00:00"/></label>
    </div>

    <div style="padding: 4px 0;">
      <label for="use_sql">Использовать SQL-запрос</label>
      <input id="use_sql" type="checkbox" name="use_sql"/>
      <div style="padding-top: 4px">
        <label>SQL
          <textarea type="text" name="sql" rows="3" cols="60" placeholder="SELECT * FROM <?php echo $wpdb->prefix ?>my_custom_form_data ORDER BY inserted_at DESC LIMIT 50"/>SELECT * FROM <?php echo $wpdb->prefix ?>my_custom_form_data ORDER BY inserted_at DESC LIMIT 50</textarea>
        </label>
        <label>Password <input type="password" name="sql_password"/></label>
      </div>
    </div>

    <?php submit_button('Скачать CSV') ?>
  </form>


  <div style="overflow:auto">
    <table class="data-table">
      <?php foreach ($csv_list as $key => $_data) { ?>
        <tr>
          <?php foreach ($_data as $val) { ?>
            <td>
              <div>
                <?php echo htmlspecialchars($val) ?>
              </div>
            </td>
          <?php } ?>
        </tr>
      <?php } ?>
    </table>
  </div>


  <style>
    #use_sql:not(:checked) + div {
      opacity: .17;
    }

    .data-table {
      border-collapse: collapse;
    }
    .data-table td {
      border: 1px solid rgba(0,0,0,.17);
      padding: 4px;
    }
    .data-table td > div{
      max-height: 60px;
      overflow: auto;
    }
    .data-table td:nth-child(5) > div{ /* from_post_title */
      min-width: 200px;
    }
    .data-table td:nth-child(6) > div{ /* inserted_at */
      min-width: 140px;
    }
  </style>

<?php } else { ?>
  Данные доступны только администратору!
<?php } ?>
