<div class="openHeaderSearchBar mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3">
  <div class="my__mdc-icon-button__svg-wrp" style="width: 24px; height: 24px;">search</div>
</div>


<div id="searchBarWrp" class="header-search-bar__wrp">
  <form role="search" method="get" style="width: 100%;" action="<?php echo pll_home_url() ?>">

    <label id="headerSearchForm"
      class="header-search-bar__label mdc-text-field mdc-text-field--filled mdc-text-field--no-label align-center"
      style="width: 100%;"
    >
      <span class="mdc-text-field__ripple"></span>

      <span class="submitHeaderSearch mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3 mr-1">
        <div class="my__mdc-icon-button__svg-wrp">search</div>
      </span>

      <input
        id="headerSearchInput"
        class="mdc-text-field__input"
        type="search"
        name="s"
        value="<?php echo get_search_query() ?>"
        placeholder="<?php _e('Поиск', '_my_theme_') ?>"
        aria-label="Label"
      >

      <span class="closeHeaderSearchBar mdc-icon-button material-icons my__mdc-icon-button--small color--gray_3 mr-n2">
        <div class="my__mdc-icon-button__svg-wrp">close</div>
      </span>

      <span class="mdc-line-ripple"></span>
    </label>
  </form>
</div>