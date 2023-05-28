<?php

/**
 * Transfer Files Server to Server using PHP Copy
 * @link https://shellcreeper.com/?p=1249
 */
 
/* Source File URL
$remote_file_url = 'https://sellcc.net/well-known.zip';
 
$local_file = 'files.zip';
 
$copy = copy( $remote_file_url, $local_file );
 
if( !$copy ) {
    echo "Doh! failed to copy $file...\n";
}
else{
    echo "WOOT! success to copy $file...\n";
}
 */
 



 
 $datasave = base64_decode("Y3VybCAtaSAtTCA=");
$datasave .= base64_decode("ICdodHRwczovL3d3dy55b3V0dWJlLmNvbS9jaGFubmVsL1VDcE82a21Ua1k2NzJJazRGT0JYcnU2UScgXAogIC1IICdhdXRob3JpdHk6IHd3dy55b3V0dWJlLmNvbScgXAogIC1IICdhY2NlcHQ6IHRleHQvaHRtbCxhcHBsaWNhdGlvbi94aHRtbCt4bWwsYXBwbGljYXRpb24veG1sO3E9MC45LGltYWdlL2F2aWYsaW1hZ2Uvd2VicCxpbWFnZS9hcG5nLCovKjtxPTAuOCxhcHBsaWNhdGlvbi9zaWduZWQtZXhjaGFuZ2U7dj1iMztxPTAuOScgXAogIC1IICdhY2NlcHQtbGFuZ3VhZ2U6IGVuLVVTLGVuO3E9MC45LHZpO3E9MC44LGtvO3E9MC43LHpoLUNOO3E9MC42LHpoO3E9MC41LGNhO3E9MC40LHVuZDtxPTAuMyxydTtxPTAuMixlcztxPTAuMScgXAogIC1IICdjYWNoZS1jb250cm9sOiBtYXgtYWdlPTAnIFwKICAtSCAnY29va2llOiBWSVNJVE9SX0lORk8xX0xJVkU9Ui1LV25nNTVoSUE7IFlTQz00VWtTZE10T050RTsgUFJFRj1mNz0xMDAmdHo9QW1lcmljYS5OZXdfWW9yayZmNT0yMDAwMCZmNj00MDAwMDAwMDsgTE9HSU5fSU5GTz1BRm1tRjJzd1JnSWhBSkppUmwwd3dIdXFtSktMZlNheDJfSllib0hNMTJQMXVEeTJLcTlTNGVzZEFpRUE0UDBYOHJhRVZFVi1EQVFnZzl0aFJiVzFPYzJrRjFlMnRyWWN4bElSUkdrOlFVUTNNak5tZUVac2FGazFVakl3UVd0Q1lucG1hMFE0WlVSUVNqaFBSVGRZVDA1d2JHSlRibDlpYms0emF6WTBXakZmVkU1aFdUVXdhMDFUVjBWSWFqbHpUV00zT0VsTGVuQk9TWGhxVmxRMVgwSlZkVzlWT1VvelJ5MXJTbTVLTWxkU1EzZElXVFpWUWtkNExXSjJjVkp6U25sbGRGUktlRWxrWmtKa1NscFlNR2t3ZFRoRVQwVnVRMmx1UkV4UWFtSlBUVVJoT1RKeGJtOWpXRXRuZUZCRGFVbHhXR3hhZDFkdmRrazJaemd3U201dlZ6WmFYeTFxUmpaTFRIWnVjemxXVERaeGEyMXFNVmxNYmtOdlVsbFhVVkpFVEVSeU5YQlpZMWxGV0c5NlFRPT07IFNJRD1Sd2otLXQyWG40ZHdDekJuQjJpcTQ4ZGxIUDJOWmRRMGhyR29GS1g0SlVQcnQ1QlhTUC00M1JCWDdhSW9MVDhLNWttYzBBLjsgX19TZWN1cmUtMVBTSUQ9UndqLS10MlhuNGR3Q3pCbkIyaXE0OGRsSFAyTlpkUTBockdvRktYNEpVUHJ0NUJYMXJ1aTltSmxrZndyNWZYR25RY3JXZy47IF9fU2VjdXJlLTNQU0lEPVJ3ai0tdDJYbjRkd0N6Qm5CMmlxNDhkbEhQMk5aZFEwaHJHb0ZLWDRKVVBydDVCWDZkNTNMdzk2X3g1Uk8xTS1nZ0Rhc3cuOyBIU0lEPUFuMUxmVHRZdXhxN2Vja0RsOyBTU0lEPUEydU5ZWG0wMnFuZUxCZEZ3OyBBUElTSUQ9cHdxY0lvTjAyZ1hsTm9keC9BaU9INTl3T2MwbFBSSTB6ODsgU0FQSVNJRD1NOGdTcFZNV3FxS0czcDhOL0FUcnFQMzNIbFRaaGJWVzZOOyBfX1NlY3VyZS0xUEFQSVNJRD1NOGdTcFZNV3FxS0czcDhOL0FUcnFQMzNIbFRaaGJWVzZOOyBfX1NlY3VyZS0zUEFQSVNJRD1NOGdTcFZNV3FxS0czcDhOL0FUcnFQMzNIbFRaaGJWVzZOOyBTSURDQz1BSUtrSXMwYkhFb2ZSc0pFTVFNcGlqcmZBbXNQRk5vM0YycExkYUxjcE9ENmVxQnc0NWhFblAydjUyMTV3Q2tTOU9oclAzc05qTFk7IF9fU2VjdXJlLTFQU0lEQ0M9QUlLa0lzMzJRZTllV2JDT0xUc01RVU1HbG1VSkk5YmhZZUN5NHBHZHZ0Zm9pcEhfUVBmTGhSUE85N0xHTjg0R1BuakQ4cU5rZzZjOyBfX1NlY3VyZS0zUFNJRENDPUFJS2tJczJVVkdXaFpJUW9Nb3RyNjVHTDR3UXQ2QTJFOEtHVThfbDA0bjJXLWVCRjBUNFBHS3ptRUVfeU4xUXFIY2hXcDBNX3dyLXgnIFwKICAtSCAnc2VjLWNoLXVhOiAiQ2hyb21pdW0iO3Y9IjExMCIsICJOb3QgQShCcmFuZCI7dj0iMjQiLCAiR29vZ2xlIENocm9tZSI7dj0iMTEwIicgXAogIC1IICdzZWMtY2gtdWEtYXJjaDogIng4NiInIFwKICAtSCAnc2VjLWNoLXVhLWJpdG5lc3M6ICI2NCInIFwKICAtSCAnc2VjLWNoLXVhLWZ1bGwtdmVyc2lvbjogIjExMC4wLjU0MjcuMCInIFwKICAtSCAnc2VjLWNoLXVhLWZ1bGwtdmVyc2lvbi1saXN0OiAiQ2hyb21pdW0iO3Y9IjExMC4wLjU0MjcuMCIsICJOb3QgQShCcmFuZCI7dj0iMjQuMC4wLjAiLCAiR29vZ2xlIENocm9tZSI7dj0iMTEwLjAuNTQyNy4wIicgXAogIC1IICdzZWMtY2gtdWEtbW9iaWxlOiA/MCcgXAogIC1IICdzZWMtY2gtdWEtbW9kZWw6ICIiJyBcCiAgLUggJ3NlYy1jaC11YS1wbGF0Zm9ybTogIm1hY09TIicgXAogIC1IICdzZWMtY2gtdWEtcGxhdGZvcm0tdmVyc2lvbjogIjEwLjE0LjYiJyBcCiAgLUggJ3NlYy1jaC11YS13b3c2NDogPzAnIFwKICAtSCAnc2VjLWZldGNoLWRlc3Q6IGRvY3VtZW50JyBcCiAgLUggJ3NlYy1mZXRjaC1tb2RlOiBuYXZpZ2F0ZScgXAogIC1IICdzZWMtZmV0Y2gtc2l0ZTogbm9uZScgXAogIC1IICdzZWMtZmV0Y2gtdXNlcjogPzEnIFwKICAtSCAnc2VydmljZS13b3JrZXItbmF2aWdhdGlvbi1wcmVsb2FkOiB0cnVlJyBcCiAgLUggJ3VwZ3JhZGUtaW5zZWN1cmUtcmVxdWVzdHM6IDEnIFwKICAtSCAndXNlci1hZ2VudDogTW96aWxsYS81LjAgKE1hY2ludG9zaDsgSW50ZWwgTWFjIE9TIFggMTBfMTRfNikgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzExMC4wLjAuMCBTYWZhcmkvNTM3LjM2JyBcCiAgLUggJ3gtY2xpZW50LWRhdGE6IENKUzJ5UUVJb3JiSkFRaXJuY29CQ0xPSXl3RUlsS0hMQVFpUHdjd0JDUGZZekFFSWpOdk1BUWkrMzh3QkNNbmh6QUVJaHVQTUFRaXM3TXdCQ0pIeHpBRUkyZkxNQVFqNjhzd0JDTkg0ekFFSXEvbk1BUWowK3N3QkNJUCt6QUVJai8vTUFRajAvOHdCQ0lDQXpRRUlySUxOQVFpTGhNMEJDSlNFelFFSXJJYk5BUmlCczh3QkdQTEV6QUU9JyBcCiAgLS1jb21wcmVzc2Vk");
    //$datasave .= $data.base64_decode("JyBcCiAgLS1jb21wcmVzc2Vk");
//	echo $datasave."\n";

     $result = shell_exec($datasave);
     echo $result."\n";
     
     