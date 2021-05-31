<?php
/*********Admin Module***************/

// master management tables

/////  Website Important Points  ///////////////////////

define("HMS_USER",'tbl_users',true);
define("HMS_USER_PIC",'tbl_user_pics',true);
define("HMS_USER_LEVEL",'tbl_user_levels',true);
define("HMS_COUNTRY",'tbl_countries',true);
define("HMS_STATE",'tbl_states',true);
define("HMS_CITY",'tbl_cities',true);
define("HMS_IDENTY",'tbl_identifications',true);
define("HMS_ROOM_TYPE",'tbl_room_types',true);
define("HMS_ROOM",'tbl_rooms',true);



define("HMS_PRODUCT",'tbl_products',true);
define("HMS_MARKET_PLACE",'tbl_market_places',true);
define("HMS_SOURCE_INFO",'tbl_source_info',true);
define("HMS_TAXS",'tbl_taxes',true);

////  Below All tables is used for Guest Reservation /////
define("HMS_GUEST",'tbl_guest',true);
define("HMS_GUEST_ADDONS",'tbl_guest_addons',true);
define("HMS_GUEST_IDENTIFICATION",'tbl_guest_identifications',true);
define("HMS_GUEST_RESERVATION",'tbl_guest_reservation',true);
define("HMS_HOLD_GUEST_RESERVATION",'tbl_guest_hold_reservation',true);
define("HMS_RESERVATION_PAYMENTS",'tbl_reservation_payments',true);
////   tables is used for Guest Reservation /////

////  Below All tables is used for banquet Reservation /////
define("HMS_EVENT_TYPE",'tbl_event_types',true);
define("HMS_BANQUET_TYPE",'tbl_banquet_types',true);
define("HMS_BANQUETS",'tbl_banquets',true);
define("HMS_BANQUETS_PAY",'tbl_banquet_payment',true);
define("HMS_BANQUETS_RESERVATION_ITEMS",'tbl_banquet_reservation_items',true);
define("HMS_BANQUET_MENU",'tbl_banquet_menu',true);
define("HMS_BANQUETS_MENU_HEADER",'tbl_banquet_header_menu',true);




////  Below All tables is used for Inventory /////
define("HMS_INVENTORY_HEARDERS",'tbl_inventory_purchase_headers',true);
define("HMS_INVENTORY_HEARDERS_CATEGORIES",'tbl_inventory_purchase_headers_categories',true);
define("HMS_PURCHASE_UNITS",'tbl_unit_types',true);
define("HMS_DISTRIBUTORS",'tbl_distributors',true);
define("HMS_PURCHSES",'tbl_inventory_purchases',true);
define("HMS_PURCHSE_LIST",'tbl_inventory_purchase_items',true);
define("HMS_ISSUED_STOCK",'tbl_inventory_issued_stock',true);
define("HMS_ISSUED_STOCK_LIST",'tbl_inventory_issued_stock_list',true);
define("HMS_REVERT_STOCK",'tbl_inventory_revert_stock',true);
define("HMS_REVERT_STOCK_LIST",'tbl_inventory_revert_stock_list',true);
define("HMS_STOCK",'tbl_inventory_stock',true);
define("HMS_BANQUET_STOCK",'tbl_inventory_issued_banquet_stock',true);
define("HMS_KITCHEN_STOCK",'tbl_inventory_issued_kitchen_stock',true);

////  KOT START HERE
define("HMS_KOT_MENU_HEADER",'tbl_kot_menu_header',true);
define("HMS_KOT_MENU",'tbl_kot_menu',true);
define("HMS_KOT",'tbl_kots',true);
define("HMS_KOT_DETAILS",'tbl_kot_details',true);


////  Housekeeping START HERE
define("HMS_HKEEPING",'tbl_housekeeping',true);
define("HMS_HKEEPING_CK_LIST",'tbl_housekeeping_check_list',true);
define("HMS_CHECKLIST",'tbl_room_checklists',true);

define("TOP_PHONENUMBER",'Call Us: 9452672531',true);
define("EMAIL_ADDRESS",'abhimishrait@gmail.com',true);
define("WEB_TITLE",'Hotel App',true);


?>