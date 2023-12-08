# IM5: Newstinder
Newstinder ist ein neuer und innovativer Weg um News zu konsumieren. Neu siehst du nicht sofort den Artikel, sondern entscheidest zu erst, ob du mehr über die News erfahren möchtest. Alle Inhalte stammen von SRF. Das Projekt Newstinder entstand im Rahmen einer Projektarbeit in «Interaktive Medien 5». In diesem Modul erarbeiteten wir eine Website welche zu unserem Bachelorthema passt. Ich werde mich in der Bachelorarbeit damit befassen, wie Lokaljournalismus junge Menschen besser erreichen kann.

## Wie funktioniert es?
Ziemlich ähnlich wie Tinder - aber mit News. Du siehst zu erst die Schlagzeile und ein Bild des Artikels. Entscheide, ob du ihn lesen möchtest (grünes Herz / nach rechts swippen) oder nicht (rotes X / nach links swippen). Am Ende der aktuellsten zehn Meldungen wirst du automatisch zu deinen «gelikten» News weitergeleitet. Jetzt kannst du die Nachricht in voller Länge lesen und/oder einen multimedialen Inhalt dazu schauen.

## Wie kann es genutzt werden?
Entweder kann die Website via URL im Abgabedokument aufgerufen werden - oder der Code kann lokal ausgeführt werden. Dabei ist wichtig, dass die Logindaten für die Datenbankverbindung ersetzt werden und die Datenbanktabellen richtig eingebunden worden ist. Die Logindaten + Datenbanktabellen finden sich im Moodle-Abgabeordner.

## Challenges
Auf dem Weg zur fertigen Website bin ich mehreren grösseren Challenges begegnet. Drei davon waren:
- Die Swipe-Funktion: Anfänglich konnte man zwar auf dem Handy swippen, auf dem Laptop jedoch nicht. Dies lag daran, dass die Website zu erst nur für Touch programmiert wurde. Nach dem die Maus-Funktion hinzugefügt wurde, konnte man swipen. Nächstes Problem: Wie werden die Swipes gespeichert? Dies habe ich mithilfe einer separaten Datenbanktabelle bewerkstelligt. Sobald eine Swipe-Aktion ausgeführt wird, schreibt diese Aktion in die Tabelle, ob es ein Like (1) oder ein Dislike (0) ist. Dies kann danach auf der Resultateseite einfach ausgelesen werden.
- Die Datenbankverbindung: Immer wieder - und aus teils unerklärlichen Gründen - hat anfänglich die Datenbankverbindung seine Tücken gehabt. Mit der Zeit konnte ich diese in den Griff bekommen. Vor allem auch, da die Verbindung zentral aufgebaut wird - und die jeweiligen Seiten auf diese zentrale Datei verweisen.
- Das Layout: Angelehnt an Tinder soll das Layout als Karten angezeigt werden. Dies ist jedoch alles andere als einfach. Zu erst wurde das Layout immer wieder «verblasen», dann stimmten die Positionierungen nicht - und als ich dies dann im Griff hatte, begann das nächste Problem: Es soll alles auch für alle Geräte responsive sein. Nach einigen Anläufen hat das auch geklappt.

## Quellen
Teile dieser Arbeit wurden mit folgenden Quellen erarbeitet:
- ChatGPT
- Modulinhalte IM 1-4 + Vorwissen aus der Mediamatiker-Ausbildung
- Newsinhalte von SRF
