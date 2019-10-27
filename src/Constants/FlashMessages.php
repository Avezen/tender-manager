<?php
/**
 * Created by PhpStorm.
 * User: Pc
 * Date: 2019-07-17
 * Time: 17:33
 */

namespace App\Constants;


class FlashMessages
{
    const AUCTION_CREATE_SUCCESS = 'Pomyślnie dodano przetarg!';
    const AUCTION_CREATE_FAILED = 'Nie uzupełniłeś wszystkich wymaganych pól';
    const AUCTION_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano przetarg!';
    const AUCTION_DELETE_SUCCESS = 'Pomyślnie usunięto przetarg!';
    const AUCTION_START_SUCCESS = 'Pomyślnie wystartowałeś przetarg!';
    const AUCTION_START_FAILED = 'Nie udało się wystartować przetargu. Dodaj grupę produktów.';
    const AUCTION_NOT_EXIST = 'Taka aukcja nie istnieje!';

    const COMPANY_CREATE_SUCCESS = 'Pomyślnie dodano firmę!';
    const COMPANY_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano firmę!';
    const COMPANY_DELETE_SUCCESS = 'Pomyślnie usunięto firmę!';

    const CONTRACTOR_CREATE_SUCCESS = 'Pomyślnie dodano kontrahenta!';
    const CONTRACTOR_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano kontrahenta!';
    const CONTRACTOR_DELETE_SUCCESS = 'Pomyślnie usunięto kontrahenta!';
    const CONTRACTOR_HAS_DATA = 'Nie można usunąć aktywnego kontrahenta';

    const LOCATION_CREATE_SUCCESS = 'Pomyślnie dodano lokalizację!';
    const LOCATION_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano lokalizację!';
    const LOCATION_DELETE_SUCCESS = 'Pomyślnie usunięto lokalizację!';

    const PRODUCT_CREATE_SUCCESS = 'Pomyślnie dodano produkt!';
    const PRODUCT_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano produkt!';
    const PRODUCT_DELETE_SUCCESS = 'Pomyślnie usunięto produkt!';

    const PRODUCT_GROUP_CREATE_SUCCESS = 'Pomyślnie dodano grupę produktów!';
    const PRODUCT_GROUP_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano grupę produktów!';
    const PRODUCT_GROUP_DELETE_SUCCESS = 'Pomyślnie usunięto grupę produktów!';

    const PRODUCT_COLUMN_CREATE_SUCCESS = 'Pomyślnie dodano kolumnę produktu!';
    const PRODUCT_COLUMN_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano kolumnę produktu!';
    const PRODUCT_COLUMN_DELETE_SUCCESS = 'Pomyślnie usunięto kolumnę produktu!';

    const PROJECT_CREATE_SUCCESS = 'Pomyślnie dodano projekt!';
    const PROJECT_UPDATE_SUCCESS = 'Pomyślnie zaktualizowano projekt!';
    const PROJECT_DELETE_SUCCESS = 'Pomyślnie usunięto projekt!';
}