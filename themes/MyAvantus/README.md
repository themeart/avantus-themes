# MyAvantus – eigene Anpassungen für Avantus

MyAvantus ist ein JTL-Child-Template mit `<Parent>Avantus</Parent>`.
Struktur, Funktionen, Ressourcen und Einstellungsdefinitionen werden von Avantus
geerbt. Der Themy Editor ist dafür nicht erforderlich.

## Installation

1. Avantus unter `templates/Avantus/` installieren.
2. Diesen Ordner vollständig nach `templates/MyAvantus/` kopieren.
3. MyAvantus im Shopbackend unter Darstellung → Einstellungen → Templates aktivieren.
4. Die Template-Einstellungen prüfen und speichern, anschließend den Shopcache leeren.

Die Mindestversion in dieser Vorlage ist JTL-Shop 5.8.4. Zusätzlich die Anforderungen
der installierten Avantus-Version beachten. Gespeicherte Template-Einstellungen
sind templatespezifisch: Individuelle Avantus-Werte werden beim Wechsel zu
MyAvantus nicht automatisch übernommen.

## Aufbau

```text
MyAvantus/
├── template.xml           Metadaten und eigene Ressourcen
├── Bootstrap.php          Erbt Funktionen und Plugin-Hooks von Avantus
├── preview-layout.png
├── README.md
├── css/custom.css         Manuelle CSS-Anpassungen für Light und Dark
├── js/custom.js           Eigene JavaScript-Erweiterungen
└── layout/
    ├── header.tpl         Vorhandene Parent-Pfadzuordnung
    └── footer.tpl         Bindet das Child-JavaScript ein
```

Weitere Vorlagen nur dort anlegen, wo tatsächlich Strukturänderungen nötig sind.
Ein eigenes `themes/`-Verzeichnis ist für diese manuellen Anpassungen nicht nötig.
Avantus behält seine gemeinsame Basis unter `themes/base/` und seine Light-/Dark-Paletten.

## CSS ohne Themy Editor

In `template.xml` ergänzt MyAvantus die bestehenden Ressourcen von Avantus:

```xml
<Minify>
    <CSS Name="light.css">
        <File Path="css/custom.css"/>
    </CSS>
    <CSS Name="dark.css">
        <File Path="css/custom.css"/>
    </CSS>
</Minify>
```

JTL lädt die Dateien der ausgewählten Ressourcengruppe. Beide Gruppen verweisen
auf dieselbe Anpassungsdatei; sie wird dadurch nicht zweimal eingebunden.
Die Gruppen ergänzen die vom Parent registrierte gemeinsame CSS-Basis.
Der frühere zusätzliche Stylesheet-Link im Child-Header ist deshalb entfernt.
Die Einbindung gilt sowohl ohne Asset-Zusammenfassung als auch für die vom Shop
zusammengefassten CSS-Ressourcen.

`css/custom.css` enthält auskommentierte Beispiele für gemeinsame Anpassungen
und getrennte Light-/Dark-Farben. Zum Aktivieren die Kommentarzeichen um den
gewünschten CSS-Block entfernen. Vorhandene `--av-*` Variablen verwenden.

Avantus setzt beim Umschalten `data-avantus-theme` am HTML-Element. Deshalb
verwenden die Beispiele `html:root[data-avantus-theme="light"]` beziehungsweise
`html:root[data-avantus-theme="dark"]`. Deren Spezifität berücksichtigt, dass beim
Umschalten eine zusätzliche Parent-Palette nachgeladen werden kann.

Reines CSS muss nicht kompiliert werden. Nach Änderungen den Shop-/Assetcache
leeren und die Seite im Browser neu laden. Wird MyAvantus verteilt, zusätzlich
seine Versionsnummer in `template.xml` erhöhen, damit Asset-URLs aktualisiert werden.
Falls eigene SCSS-Dateien verwendet werden, müssen diese zunächst in die
registrierte CSS-Datei kompiliert werden.

## Struktur über Smarty-Blöcke ändern

Den relativen Pfad der gewünschten Parent-Vorlage im Child anlegen und nur
betroffene Blöcke erweitern. Beispiel für `productdetails/details.tpl`:

```smarty
{extends file="{$parent_template_path}productdetails/details.tpl"}

{block name='productdetails-details-info-product-title' append}
    <p class="text-muted">Eigener zusätzlicher Inhalt.</p>
{/block}
```

Den Blocknamen vor der Verwendung in der aktuellen Parent-Datei prüfen.
`append` ergänzt danach, `prepend` davor. Ohne diese Zusätze wird der Block
ersetzt; `{$smarty.block.parent}` übernimmt seinen ursprünglichen Inhalt.
Bestehende Klassen, IDs, Formularfelder und Plugin-Hooks erhalten, wenn deren
Funktionen weiter genutzt werden. Keine kompletten Parent-Layouts kopieren.

## JavaScript und eigene Dateien

`js/custom.js` wird durch den vorhandenen Child-Footer eingebunden.
Nicht zusätzlich denselben Script-Link oder einen zweiten XML-Eintrag anlegen.
Für Code mit DOM-Abhängigkeiten die passenden Lade- beziehungsweise
Komponentenereignisse verwenden.

Der Bootstrap stellt `{$myAvantusBaseURL}` für eigene Dateien bereit, beispielsweise
`{$myAvantusBaseURL}images/eigenes-bild.svg`. Bei Erweiterungen des Bootstraps
`parent::boot()` beibehalten.

## Einstellungen, Themy und Grenzen

Die geerbten Template-Einstellungen können weiterhin im Shopbackend geändert
werden. Eigene zusätzliche Einstellungen lassen sich in `template.xml` unter
`<Settings>` ergänzen. Themy ist optional und speichert seine Anpassungen separat
im Plugin. Werden dieselben Eigenschaften zusätzlich manuell verändert,
entscheiden Spezifität und Reihenfolge der CSS-Regeln über den sichtbaren Wert.

Das aktuelle Child enthält noch die bestehende Pfadzuordnung im Header.
Damit ist die im Parent vorhandene Asset-Auflösung nicht insgesamt überarbeitet:
Wartungsseite und Video-Platzhalter enthalten weitere direkte Child-Pfade, die
separat korrigiert werden müssen. Ein vollständiger Funktionstest ist daher vor
Produktiveinsatz erforderlich. Zusätzliche Paletten sowie eigene Header- und
Navigations-XML-Dateien im Child werden vom derzeitigen Parent nicht automatisch
eingelesen; Smarty-Anpassungen und die vorhandenen Template-Einstellungen bleiben
der vorgesehene Weg für diesen Starter.

## Updates

Avantus separat aktualisieren. Eigene Anpassungen in MyAvantus bleiben dabei
erhalten. Den angepassten Child-Ordner nicht durch eine neue Starterkopie ersetzen.
Nach Parent-Updates die überschriebenen Smarty-Blöcke und verwendeten Variablen
prüfen sowie Desktop/Mobil und Light/Dark kontrollieren.
