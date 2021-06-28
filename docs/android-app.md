[&laquo; Back to the README.md](../README.md)

# Android App Documentatie
Voor het RegattaTracker project hebben wij ook een simpele Android app gemaakt. Wat deze app doet is niets meer dan de RegattaTracker website open in een `WebView`. Dus het is eigenlijk een veredelde webbrowser. Dit is waar maar het geeft gebuikers wel gelijk de kans om in een klik de RegattaTracker website te openen en ook nog fullscreen.

Dit is trouwens ook gewoon mogelijk met een Progressive Web App wat onze website trouwens ook is (we hebben een `/manifest.json` waarin verschillende specs staan). Maar dan op Android voegd Chrome er een Chrome logo aan toe en het werkt niet echt pijnloos. Daarom hebben we de app gemaakt op deze pagina staat nog wat meer uitleg over hoe de app werkt:

## Build System
De app is niet gemaakt met het standaard Gradle Android build systeem want dit build systeem is heel erg traag (1 a 2 min wachten voor basic app) en zorgt ook voor erge bloated apks (1 tot 2 MB voor basic app). Deze grote komt voornamelijk doordat er allemaal compat libs worden toegevoegd die je eigenlijk niet echt nodig hebt.

Het build script is eigenlijk gewoon een schell script die `javac` en `aapt2` commando's aanroept om je app te bouwen, signen en te uploaded naar je telefoon, je hoeft eigenlijk alleen maar `./build.sh` in je command line in te typen om de app te bouwen. Je hebt natuurlijk wel eerst een Java JDK nodig en ook nog de android command line tools.

## Icons
Android maakt tegenwoordig (sinds Android Oreo) gebruik van adaptive icons dit zijn eigenlijk icoontjes met twee verschillende lagen namelijk: een achtergrond laag en een voorgrond laag. Dit zorgt er voor dat je een icoontje in verschillende vormen kan vormen en ook nog dat je leuke animaties kan doen.

We hadden voor de RegattaTracker al een icoontje ontworpen die je kan vinden in de `public/images` folder. Dit icoontje heb ik ook gebruik voor de Android app ik heb eerste de achtergrond laag gemaakt in een XML bestand (alles in Android dev is XML of Java / Kotlin).

De adaptive icon in `mipmap-anydpi-v26/ic_launcher.xml`:
```xml
<adaptive-icon xmlns:android="http://schemas.android.com/apk/res/android">
    <background android:drawable="@color/ic_launcher_background_color" />
    <foreground android:drawable="@drawable/ic_launcher_foreground" />
</adaptive-icon>
```
Met de kleuren in `values/ic_launcher_colors.xml`:
```xml
<resources>
    <color name="ic_launcher_background_color">#fff</color>
    <color name="ic_launcher_foreground_color">#111</color>
</resources>
```
En het echte icoontje in `drawable-anydpi-v21/ic_launcher_foreground.xml`:
```xml
<vector xmlns:android="http://schemas.android.com/apk/res/android" android:width="108dp" android:height="108dp" android:viewportWidth="24" android:viewportHeight="24">
   <group android:translateX="6" android:translateY="6" android:scaleX="0.5" android:scaleY="0.5">
       <path android:fillColor="@color/ic_launcher_foreground_color" android:pathData="M7,17L10.2,10.2L17,7L13.8,13.8L7,17M12,11.1A0.9,0.9 0 0,0 11.1,12A0.9,0.9 0 0,0 12,12.9A0.9,0.9 0 0,0 12.9,12A0.9,0.9 0 0,0 12,11.1M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4Z"/>
   </group>
</vector>
```
Zoals je kan zien maakt android in een VectorDrawable niet gebruik van de SVG spec maar hebben ze een simpeler alternatief gebruikt. Alleen het path element is wel compatible met SVG path data zo kan je vector icoontjes die eigenlijk gewoon SVG paths zijn gewoon kopieren en verder verwerken.

## Layout
De app heeft een vrij simpele layout met een paar elementen die in het `layout/activity_main.xml` bestand staan:
```xml
<FrameLayout xmlns:android="http://schemas.android.com/apk/res/android"
    style="@style/Root">

    <!-- Webview page -->
    <WebView android:id="@+id/main_webview_page"
        style="@style/Root" />

    <!-- Disconnected page -->
    <LinearLayout android:id="@+id/main_disconnected_page"
        android:visibility="gone"
        style="@style/Root">

        <LinearLayout style="@style/ActionBar">
            <TextView android:text="@string/app_name"
                style="@style/ActionBarTitle" />

            <ImageButton android:id="@+id/main_disconnected_refresh_button"
                android:src="@drawable/ic_refresh"
                style="@style/ActionBarIconButton" />
        </LinearLayout>

        <ScrollView android:id="@+id/main_disconnected_scroll"
            style="@style/Scroll">

            <!-- ... -->
        </ScrollView>
    </LinearLayout>
</FrameLayout>
```
Zoals je kan zien bestaat de main activity (hoofd pagina) uit een container met daarin een webview en een andere disconnected pagina. Deze pagina word weergeven wanneer er geen internet verbinden meer is. Op deze pagina staat ook een reconnect knop om te proberen om weer opnieuw te verbinden. De webview is eigenlijk gewoon een webbrowser in een view / widget die je in je Android app gewoon kan weergeven.

## MainActivity
In de `MainActivity.java` staat alle code / logica van de app het aardig wat maar met een paar snippets zal ik uitleggen wat er gebeurd:

Eerst word dat activity geinitieerd waarnaar de layout xml wordt ingeladen via de `setContentView` method:
```java
public void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    setTitle(getResources().getString(R.string.app_name));
    setContentView(R.layout.activity_main);
```
Daarna volgd aardig wat code voor de webview maar aan het einde staat nog wel iets interresants namelijk de code die de website url in laad. Als de activity een `ACTION_VIEW` intent (bericht) binnen krijgt opend de activity deze pagina. Dit bericht komt binnen als er buiten de app de url wordt geopend. Want in de `AndroidManifest.xml` staat aangegeven dat deze app alle pagina's naar de regattatracker website wilt open.
```java
    Intent intent = getIntent();
    if (intent.getAction() == Intent.ACTION_VIEW) {
        webviewPage.loadUrl(intent.getDataString());
    } else {
        webviewPage.loadUrl("https://test.regattatracker.nl/");
    }
```
In Android had je natuurlijk ook een terug / back button als je deze indrukt dan zal de app terug gaan in de browser geschiedenis totdat hij op de home pagina is dan zal hij de activity vernietigen dit doe je door het standaard gedrag van de `onBackPressed` method aan te roepen:
```java
public void onBackPressed() {
    if (disconnectedPage.getVisibility() == View.VISIBLE) {
        super.onBackPressed();
    }

    if (Uri.parse(webviewPage.getUrl()).getPath().equals("/")) {
        super.onBackPressed();
    }

    if (webviewPage.canGoBack()) {
        webviewPage.goBack();
    } else {
        super.onBackPressed();
    }
}
```
