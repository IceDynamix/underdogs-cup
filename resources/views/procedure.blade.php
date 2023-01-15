<x-layout>
    <x-slot:title>
        Match Procedure
    </x-slot:title>

    <div class="container">
        <div class="content">
            <h2 id="match-procedure">Match Procedure</h2>

            <h3 id="finding-your-match-up">1. Finding your match-up</h3>
            <p>

                Check the Challonge for your match-up! The Challonge bracket will be
                filled
                roughly 5-10 minutes after check-ins have concluded.
            </p>

            <h3 id="contacting-your-opponent">2. Contacting your opponent</h3>
            <p>
                Look for your opponent's Discord and ping them accordingly in the<code>#find-your-opponent</code>channel.
                Their Discord username should be the same as their Tetr.io username. If a player does not reply
                within 10 minutes, please open a new post in the <code>#tournament-help</code> forum channel and tag it
                as "Missing opponent". If your match has been chosen as
                a streamed match, please stand by and wait for staff instructions.
            </p>
            <p>
                Refer to: <a href="/#communication">Communication</a>
            </p>

            <h3 id="creating-the-room">3. Creating the room</h3>
            <p>
                Once you've contacted the opponent, create a private Tetr.io room, invite your opponent and use the
                appropriate command in the multiplayer room chat to set the tournament settings.
            </p>
            <ul>
                <li>Matches until top 8:
                    <code>/set meta.match.ft=5;game.options.gincrease=0.0035;game.options.gmargin=7200</code>
                </li>
                <li>Matches after top 8:
                    <code>/set meta.match.ft=7;game.options.gincrease=0.0035;game.options.gmargin=7200</code>
                </li>
            </ul>

            <h3 id="playing-the-match">4. Playing the match</h3>
            <p>
                This should be the easiest part, it's what you came for in the end! Please refer to following rule
                sections when necessary:
            </p>
            <ul>
                <li><a href="/#warmup">Warmup</a></li>
                <li><a href="/#disconnect">Disconnect</a></li>
            </ul>

            <h3 id="posting-your-match-results">5. Reporting your match results</h3>
            <p>
                We are now using the UC parasite Discord Bot to report match results.
            </p>

            <p>
                Once your match has concluded, use the <code>/report</code> command in the <code>#match-reports</code>
                channel.
            </p>

            <img src="https://cdn.discordapp.com/attachments/746479190739648584/1064276495033450556/image.png"
                 alt="/report command">

            <p>
                Submit the form by filling in the modal with the scores.</p>

            <img src="https://cdn.discordapp.com/attachments/746479190739648584/1064276546346553394/image.png"
                 alt="Command modal">

            <p>Once you receive your confirmation message, you can continue in the tournament!</p>

            <img src="https://cdn.discordapp.com/attachments/746479190739648584/1064276650092679258/image.png"
                 alt="Confirmation message">

            <p>
                Only the first reported match result will be accepted, so only one person needs to report it. Any match
                reports for that match after the first one will be rejected.
            </p>

            <p>
                <b>If your match is FT7, do <i>not</i> submit your match result yet until top 8. We will make it
                    abundantly clear when you start FT7 matches, every early match should be FT5.</b>
            </p>

            <p>
                If there has been an incorrect match report, please open a new post in the <code>#tournament-help</code>
                forum channel and tag it as "Wrong Match Result". Staff will take care of the result.
            </p>

            <h3 id="repeat-the-process">6. Repeat the process</h3>
            <p>
                Look out for your next match-up and repeat the previous steps!
            </p>
            <p>
                The Challonge will update in real-time as staff members enter the results. If your match-up is empty,
                then please be patient and wait until the opponent matches have concluded and staff has entered the
                results.
            </p>
            <p>
                Do keep in mind that this tournament is Double Elimination, which
                means that you have to lose twice to be eliminated from the tournament.
                Good luck and have fun!
            </p>
        </div>
    </div>
</x-layout>
