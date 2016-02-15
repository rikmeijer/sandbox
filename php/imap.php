<?php

require __DIR__ . DIRECTORY_SEPARATOR . "vendor/autoload.php";

$ews = new PhpEws\EwsConnection("webmail.avans.nl", $_SERVER['argv'][1], $_SERVER['argv'][2]);

// Set init class
$request = new PhpEws\DataType\FindItemType();
// Use this to search only the items in the parent directory in question or use ::SOFT_DELETED
// to identify "soft deleted" items, i.e. not visible and not in the trash can.
$request->Traversal = PhpEws\DataType\ItemQueryTraversalType::SHALLOW;
// This identifies the set of properties to return in an item or folder response
$request->ItemShape = new PhpEws\DataType\ItemResponseShapeType();
$request->ItemShape->BaseShape = PhpEws\DataType\DefaultShapeNamesType::DEFAULT_PROPERTIES;

// Define the timeframe to load calendar items
$request->CalendarView = new PhpEws\DataType\CalendarViewType();
$request->CalendarView->StartDate = "2015-12-16T08:45:00+00:00";// an ISO8601 date e.g. 2012-06-12T15:18:34+03:00
$request->CalendarView->EndDate = "2015-12-17T14:35:00+00:00"; // an ISO8601 date later than the above

// Only look in the "calendars folder"
$request->ParentFolderIds = new PhpEws\DataType\NonEmptyArrayOfBaseFolderIdsType();
$request->ParentFolderIds->DistinguishedFolderId = new PhpEws\DataType\DistinguishedFolderIdType();
$request->ParentFolderIds->DistinguishedFolderId->Id = PhpEws\DataType\DistinguishedFolderIdNameType::CALENDAR;

// Send request
$response = $ews->FindItem($request);

// Loop through each item if event(s) were found in the timeframe specified
$lesuren = [];
if ($response->ResponseMessages->FindItemResponseMessage->RootFolder->TotalItemsInView > 0){
    $events = $response->ResponseMessages->FindItemResponseMessage->RootFolder->Items->CalendarItem;
    foreach ($events as $event){
//         $id = $event->ItemId->Id;
//         $change_key = $event->ItemId->ChangeKey;
//         $start = $event->Start;
//         $end = $event->End;
//         $subject = $event->Subject;
//         $location = $event->Location;
        
        var_dump($event);
        $requestExtended = new PhpEws\DataType\GetItemType();
        
        $requestExtended->ItemShape = new PhpEws\DataType\ItemResponseShapeType();
        $requestExtended->ItemShape->BaseShape = PhpEws\DataType\DefaultShapeNamesType::ALL_PROPERTIES;
        $requestExtended->ItemShape->AdditionalProperties = new PhpEws\DataType\NonEmptyArrayOfPathsToElementType();
        
        $extendedProperty = new PhpEws\DataType\PathToExtendedFieldType();
        $extendedProperty->PropertyName = 'Description';
        $extendedProperty->PropertyType = PhpEws\DataType\MapiPropertyTypeType::STRING;
        $extendedProperty->DistinguishedPropertySetId = PhpEws\DataType\DistinguishedPropertySetIdType::PUBLIC_STRINGS;
        $requestExtended->ItemShape->AdditionalProperties->ExtendedFieldURI = array($extendedProperty);
        
        $requestExtended->ItemIds = new PhpEws\DataType\NonEmptyArrayOfBaseItemIdsType();
        $requestExtended->ItemIds->ItemId = new PhpEws\DataType\ItemIdType();
        $requestExtended->ItemIds->ItemId->Id = $event->ItemId->Id;
        
        $responseExtended = $ews->GetItem($requestExtended);
        
        print_r($responseExtended);
        $lesuren[$event->ItemId->Id] = [
            'subject' => $event->Subject,
            'start' => new DateTime($event->Start),
            'end' => new DateTime($event->End),
            'location' => $event->Location
        ];
    }
}
else {
    // No items returned
}


echo '<pre>'.print_r($lesuren, true).'</pre>';