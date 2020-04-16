# Abnahme Checkliste KBDB 20.02.2020
### Wesentliches Update 13.03.2020 
### Änderungen nach Kontrolle 13.03.2020 
### Update nach Kontrolle 16.03.2020 
### Update Feature-Erweiterungen 30.03.2020
(Speicherort dieses Dokument: git:kbdb/docs/Abnahme 2020.02.20.md)
***
## Kunden anzeigen
### *Hauptansicht*
- [ ] Suchfeld funktioniert
- [ ] Erster Click wird übernommen
- [ ] Anzeige Kontakte funktioniert
- [ ] Anzeige Adressen funktioniert
- [ ] Anzeige Berichte funktioniert
	- [ ] Kontakperson wird immer richtig angezeigt (Softdelte BUG)
- [ ] Tab-Position bleibt stehen nach Wechsel des Kunden (erneutes Clicken auf denselben
Kunden springt zu Kontakte)
- [ ] "Neuer Kontakt" wird angezeigt bei Drücken von + aus Kontakte Ansicht heraus
- [ ] "Neue Adresse" wird angezeigt bei Drücken von + aus Adress-Ansicht heraus
- [ ] "Neuer Bericht" wird angezeigt bei Drücken von + aus Berichte Ansicht heraus
- [ ] Kundenfelder sind einzeln editierbar und zeigen das Eingabefeld passend zum Datentyp
- [ ] Kontaktefelder sind einzeln editierbar und zeigen das Eingabefeld passend zum Datentyp
- [ ] Adressfelder sind einzeln editierbar und zeigen das Eingabefeld passend zum Datentyp
- [ ] Berichte sind nicht editierbar
- [ ] Rückmeldung bei Speichern über Message-Feld funktioniert
##### Anzeige Kontakte
- [ ] Reguläre Kontakte werden über temporären angezeigt
- [ ] Sortierung adhoc->name
- [ ] Temporäre und reguläre Kontakte können gelöscht werden
- [ ] Temporäre Kontakte können in reguläre umgewandelt werden
	- [ ] Nach dem Löschen werden Sie weiterhin in den Kontakberichten angezeigt
- [ ] Beide Aktionen können vorher noch bestätigt oder abgebrochen werden
- [ ] Nach Bestätigen wird die Liste aktualisiert; der temporäre Kontakt wird als regulärer
 angezeigt
##### Update Kunde einzelne Felder (Test mit F5)
- [ ] Name
- [ ] Kürzel
- [ ] Kundenbetreuer
- [ ] Level
- [ ] Verbotskunde
##### Update Kontakt einzelne Felder (Test mit F5)
- [ ] Titel
- [ ] Vorname
- [ ] Nachname
- [ ] Gender
- [ ] Abteilung
- [ ] Position
###### Änderungen Kontakt Verbindungen
- [ ] Verbindung hinzufügen funktioniert
- [ ] Hinzufügen abbrechen funktioniert
- [ ] Leere Eingabe bestätigen geht nicht
- [ ] Bestätigen funktioniert
- [ ] Eintrag bearbeiten funktioniert
- [ ] Eintrag löschen funktioniert
###### Änderungen Kontakt Bemerkungen
- [ ] Bemerkung hinzufügen funktioniert
- [ ] Hinzufügen abbrechen funktioniert
- [ ] Leere Eingabe bestätigen geht nicht
- [ ] Bestätigen funktioniert
- [ ] Eintrag bearbeiten funktioniert
- [ ] Eintrag löschen funktioniert
##### Update Adresse einzelne Felder (Test mit F5)
- [ ] Typ
- [ ] Feld 1
- [ ] Feld 2
- [ ] Feld 3
- [ ] Straße
- [ ] LKZ
- [ ] PLZ
- [ ] Stadt
###### Änderungen Adresse Verbindungen
- [ ] Verbindung hinzufügen funktioniert
- [ ] Hinzufügen abbrechen funktioniert
- [ ] Leere Eingabe bestätigen geht nicht
- [ ] Bestätigen funktioniert
- [ ] Eintrag bearbeiten funktioniert
- [ ] Eintrag löschen funktioniert
###### Änderungen Adresse Bemerkungen
- [ ] Bemerkung hinzufügen funktioniert
- [ ] Hinzufügen abbrechen funktioniert
- [ ] Leere Eingabe bestätigen geht nicht
- [ ] Bestätigen funktioniert
- [ ] Eintrag bearbeiten funktioniert
- [ ] Eintrag löschen funktioniert
##### Update Bericht einzelne Felder (Test mit F5)
- [ ] Datum
- [ ] Gesprächspartner
- [ ] Kontaktperson
- [ ] Gesprächsart
- [ ] Notitzen
##### Neuer Kontakt
- [ ] Die Ansicht wechselt zur Kontakt-Erstellen-Seite
- [ ] Kontakt wird gespeichert und die Ansicht springt in die Kontakteliste
- [ ] Der neue Kontakt wird sofort nach dem Erstellen angezeigt
- [ ] Der neue Kontakt wird nach Aufruf des Kunden angezeigt
- [ ] Rückmeldung über Message-Feld
##### Neue Adresse
- [ ] Die Ansicht wechselt zur Adresse-Erstellen-Seite
- [ ] Adresse wird gespeichert und die Ansicht springt in die Adressenliste
- [ ] Die neue Adresse wird sofort nach dem Erstellen angezeigt
- [ ] Die neue Adresse wird nach Aufruf des Kunden angezeigt
- [ ] Rückmeldung über Message-Feld
- [ ] Feld1, Feld2, Straße sind nicht erforderlich
##### Neuer Bericht
- [ ] Die Ansicht wechselt zur Bericht-Erstellen-Seite
- [ ] Bericht wird gespeichert
- [ ] Der neue Bericht wird angezeigt
- [ ] Rückmeldung über Message-Feld
### *Neuer Kunde*
- [ ] Formular mit Addresseingabe wird angezeigt
- [ ] Kundenbetreuer Eingabe zeigt Liste
- [ ] Click auf Liste übernimmt --> Was bedeutet der Punkt?
- [ ] Speichern funktioniert
- [ ] Rückmeldung über Message-Feld
- [ ] Neu erstellter Kunde kann über Suchfeld gefunden werden
- [ ] Die eingegebenen Werte stimmen überein
- [ ] Feld1, Feld2, Straße sind nicht erforderlich
***
## Bericht erstellen
- [ ] Suchfeld Kunde funktioniert
	- [ ] Schnellauswahl mit suchkriterien (k:, o:) funktionert
- [ ] Nach Auswahl Kunde -> Click in Gesprächspartner listet alle Einträge zum gewählten Kunden (ohne Eingabe)
- [ ] Suchfeld Gesprächspartner funktioniert
- [ ] Suchfeld Gesprächspartner zeigt adhoc Einträge wenn Kunde augewählt
- [ ] (Suchfeld Gesprächspartner zeigt keine adhoc Einträge wenn kein Kunde augewählt wurde)
- [ ] Suchfeld Gesprächspartner zeigt Liste nach Click und sucht ab dem ersten Zeichen
- [ ] Temporäre Gesprächspartner werden ebenso in Kontakte gelistet
- [ ] Bei Auswahl Gesprächspartner wird der zugehörige Kunde automatisch eingetragen
- [ ] Gesprächsart wird beim Speichern übernommen, ohne dass eine Auswahl getroffen wird
- [ ] Temporäre Gesprächspartner werden beim Speichern angelegt
- [ ] Speichern funktioniert mit Rückmeldung
- [ ] Der gespeicherte Bericht wird in der Kundenanzeige beim jeweiligen Kunden gelistet
***
## Offene Kontakttermine
- [ ] Eingabe Kundenmanager aktualisiert Liste
- [ ] Checkbox 'Ohne Kundenmanager' aktualisiert Liste und zeigt zusätzlich Termine ohne KM
- [ ] 'Termine bis' aktualisiert Liste
- [ ] Datum ändern wird übernommen/ aktualisiert Liste
- [ ] 'Termine bis' hat default Datum -7 Tage
- [ ] next_contact wird gespeichert und aktualisiert Liste
***
## Benutzer verwalten
- [ ] Suchfeld funktioniert
- [ ] Erster Click funktioniert
- [ ] Soft-deleted/inaktive Benutzer werden angezeigt
- [ ] Speichern von Änderungen funktioniert
- [ ] Passwort generieren funktioniert
- [ ] Neuer Benutzer wird gespeichert
- [ ] Finden über Suchfeld
- [ ] Passwort ändern funktioniert
- [ ] (Nach dem Speichern springt die eingabe wieder in das Suchmenue)
- [ ] Nach dem Speichern wird der erstellte Benutzer in der Edit-Ansicht angezeigt
- [ ] Deaktivierte Benutzer koennen sich nicht anmelden
***
## Erweiterte Daten
- [ ] Auswahl Typ zeigt Typdetails
- [ ] Klick->Neu zeigt leeres Formular
- [ ] Speichern zeigt neues Element in Liste
- [ ] Klick auf Typeintrag zeigt Eintrag in Formular
- [ ] Änderung wird in Liste angezeigt
- [ ] Adresstyp alle Funktionen
- [ ] Gesprächsart alle Funktionen
- [ ] Branche alle Funktionen
- [ ] Verbindungstyp alle Funktionen
- [ ] Bemerkungstyp
***
## Abschließend
- [ ] Console Logs entfernt
***
## Ideen
- Bisherige Eingaben/Einstellungen werden gecashed, so dass beim Wechsel der Ansicht diese
 wiederhergestellt werden
- next contacts: Kundenmanager anzeigen und bearbeitbar
