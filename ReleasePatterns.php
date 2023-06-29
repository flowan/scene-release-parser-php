<?php
namespace ReleaseParser;

/**
 * ReleasePatterns - All needed patterns for properly parsing releases.
 *
 * @package ReleaseParser
 * @author Wellington Estevo
 * @version 1.0.3
 */

class ReleasePatterns {

	// Declaration of some needed regex patterns.
	// https://regex101.com/ is your best friend for testing those patterns.
	// %varname% will be replaced with the parsed valued for better macthing.

	// Find language (old: (?!sub))
	const REGEX_LANGUAGE = '/[._\(-]%language_pattern%[._\)-][._\(-]?(?:%source%|%format%|%audio%|%flags%|%year%|%os%|%device%|%resolution%|multi|ml[._\)-]|dl[._\)-]|dual[._-]|%group%)/i';
	// Find date
	const REGEX_DATE = '(\d{2}|\d{4})[._-](\d{2})[._-](\d{2}|\d{4})';
	// Special date with month name: 24th January 2002 / Sep. 2000 day 5 / January 2000 1
	const REGEX_DATE_MONTHNAME = '(\d{1,2})?(?:th|rd|st|nd)?[._-]?(%monthname%)[._-]?(\d{1,2})?(?:th|rd|st|nd)?[._-]?(\d{4})[._-]?(?:day[._-]?)?(\d{1,2})?';
	// Description with date inside brackets is nearly always music or musicvideo
	const REGEX_DATE_MUSIC = '/\([a-z._]+[._-]' . self::REGEX_DATE . '\)/i';
	// Get right year
	const REGEX_YEAR = '/(?=[\(._-](19\d[\dx]|20\d[\dx])[\)._-])/i';
	// Extract group
	const REGEX_GROUP = '/-(\w+)$/i';
	// Extract OS
	//const REGEX_OS = '';
	// Episode pattern matches: S01E01 / 1x01 / E(PS)1 / OVA1 / F123 / Folge_123 / Episode 1 / Issue 1 etc.
	// Good for tv and audiobook rls
	const REGEX_EPISODE = '(?:(?:s\d+[._-]?)?(?:s?ep?|o[av]+[._-]?|f(?:olge[._-])?|band[._-]?|issue[._-]?|ausgabe[._-]?|n[or]?[._-]?|eps[._-]?|episode[._-]?|sets?[._-]?)([\d_-]+)|(?:\d+x)(\d+))';
	const REGEX_EPISODE_TV = '(?:(?:[ST]\d+)?[._-]?(?:ep?|o[av]+[._-]?|d|eps[._-]?|episode[._-]?)[\d-]+|\d+x\d+|[STD]\d+)';
	// Season pattern matches: S01E01 / 1x01
	const REGEX_SEASON = '/[._-](?:[ST](\d+)[._-]?(?:[EDP]+\d+)?|(\d+)(?:x\d+))[._-]/i';
	// Basic title pattern
	const REGEX_TITLE = '([\w.\(\)-]+)';
	// Good for Ebooks
	const REGEX_TITLE_EBOOK = '/^' . self::REGEX_TITLE . '[._\(-]+(?:%year%|%language%|%flags%|%format%|%regex_date%|%regex_date_monthname%)[._\)-]/iU';
	// Good for Fonts
	const REGEX_TITLE_FONT = '/^' . self::REGEX_TITLE . '-/i';
	// Good for Movies
	const REGEX_TITLE_MOVIE = '/^' . self::REGEX_TITLE . '[._\(-]+(?:%year%|%language%|%source%|%flags%|%format%)[._\)-]/iU';
	// Music pattern matches: Author_2.0_(Name)-Track_album_title_2.0_-_track_bla_(Extended_edition)-...
	// Good for music releases and Audiobooks
	const REGEX_TITLE_MUSIC = '/^' . self::REGEX_TITLE . '(?:\([\w-]+\))?[._\(-]+(?:%source%[._\)-]|%year%|%group%|%audio%|%flags%|%format%|%regex_date%|%regex_date_monthname%|%language%[._\)-])/iU';
	const REGEX_TITLE_ABOOK = '/^' . self::REGEX_TITLE . '[._\(-]+(?:%source%[._\)-]|%year%|%group%|%audio%|%flags%|%format%|%language%[._\)-])/iU';
	const REGEX_TITLE_MVID = '/^' . self::REGEX_TITLE . '[._\(-]+(?:%source%|%year%|%group%|%audio%|%flags%|%format%|%regex_date%|%regex_date_monthname%|%language%[._\)-])/iU';
	// Good for general Software releases (also Games)
	const REGEX_TITLE_APP = '/^' . self::REGEX_TITLE . '[._\(-]+(?:' . self::REGEX_VERSION_TEXT . '[._\(-]?\d|%language%|%flags%|%device%|%format%|%os%|%group%|%source%)/iU';
	// Good for all kind of series (also Anime)
	const REGEX_TITLE_TV = '/^' . self::REGEX_TITLE . '[._-]' . self::REGEX_EPISODE_TV . '/iU';
	const REGEX_TITLE_TV_EPISODE = '/' . self::REGEX_EPISODE_TV . '[._-](?:' . self::REGEX_TITLE . '[._\(-]+)?(?:%language%[._\)-]|%resolution%|%source%|%flags%|%format%)/iU';
	const REGEX_TITLE_TV_DATE = '/^' . self::REGEX_TITLE . '[._\(-]+(?:%regex_date%|%year%)[._\)-]' . self::REGEX_TITLE . '?[._\(-]?(?:%language%[._\)-]|%resolution%|%source%|%flags%|%format%)/iU';
	// Good for XXX paysite releases
	const REGEX_TITLE_XXX = '/^' . self::REGEX_TITLE . '[._\(-]+(?:%year%|%language%[._\)-]|%flags%)/iU';
	//const REGEX_TITLE_XXX_DATE = '/^' . self::REGEX_TITLE . '[._-](?:\d+\.){3}' . self::REGEX_TITLE . '[._-](?:xxx|%language%)/iU';
	const REGEX_TITLE_XXX_DATE = '/^' . self::REGEX_TITLE . '[._\(-]+(?:%regex_date%|%regex_date_monthname%)[._\)-]+' . self::REGEX_TITLE . '[._\(-]+(?:%flags%|%language%[._\)-])/iU';
	// Extract software version
	const REGEX_VERSION_TEXT = '(?:v(?:ersion)?|Updated?[._-]?v?|Build)';
	const REGEX_VERSION = self::REGEX_VERSION_TEXT . '[._-]?([\d.]+[a-z\d]{0,3}(?![._-]gage))';


	// Type patterns.
	// Default type will be set to 'Movie' if no other matches.
	const TYPE = [
		// Audiobook
		'ABook' => 'a.*book',
		// Anime
		'Anime' => 'anime',
		// Software Sections
		'App' => [ 'app', '0day', 'pda' ],
		// Ebook
		'eBook' => 'book',
		// Font
		'Font' => 'font',
		// Game/Console Sections
		'Game' => [ 'GAME', 'D[SC]', 'G[BC]', 'NSW', 'PS', 'XBOX', 'WII' ],
		// Music Sections
		'Music' => [ 'mp3', 'flac', 'music' ],
		// Music Video Sections
		'MusicVideo' => 'm(vid|dvd|bluray)',
		// TV Sections
		'TV' => [ 'tv', 'sport' ],
		// XXX Sections
		'XXX' => [ 'xxx', 'imgset' ],
		// Movie Sections
		'Movie' => [ 'movie', '(?!tv).*26[45]', 'bluray', 'dvdr', 'xvid', 'divx' ],
	];

	// Video/Audio source patterns
	const SOURCE = [
		'ATVP' => 'ATVP', // Apple TV
		'AUD' => 'AUD', // Audience Microphone
		'BDRip' => 'b[dr]+[._-]?rip',
		'Bluray Screener' => [ 'bluray[._-]?scr', 'bd[._-]?scr' ],
		'Bootleg' => '(?:LIVE|\d*cd)?[._-]?BOOTLEG',
		'CABLE' => 'cable',
		'CAM' => 'cam([._-]?rip)?',
		'CD Album' => '\d*cda', // CD Album
		'CD EP' => 'cdep',
		'CD Single' => [ 'cd[sm]', 'mcd', '(?:(?:cd|maxi)[._-]?)single', 'cd[._-]?maxi' ], // CD Maxi / Single
		'Web Single' => [ 'web[._-]single|single[._-]web' ], // Web single
		'Console DVD' => [ 'xboxdvdr?', 'ps2dvd' ],
		'DAT Tape' => 'DAT', // Digital Audio Tape
		'DAB' => 'dab', // Digital Audio Broadcast
		'DDC' => 'ddc', // Downloadable/Direct Digital Content
		'DSR' => [ 'dsr', 'dth', 'dsr?[._-]?rip', 'sat[._-]?rip', 'dth[._-]?rip' ], // Digital satellite rip (DSR, also called SATRip or DTH)
		'DVB' => [ 'dvb[sct]?(?:[._-]?rip)?', 'dtv', 'digi?[._-]?rip' ],
		'DVDA' => '\d*dvd[_-]?a', // Audio DVD
		'DVDS' => 'dvd[_-]?s', // DVD Single
		'DVDRip' => '(?:r\d[._-])?dvd[._-]?rip(?:xxx)?',
		'DVD Screener' => [ 'dvd[._-]?scr', '(?:dvd[._-]?)?screener', 'scr' ],
		'EDTV' => 'EDTV(?:[._-]rip)?', // Enhanced-definition television
		'EP' => 'EP',
		'HDDVD' => 'hd[._-]?dvdr?',
		'HDRip' => [ 'hd[._-]?rip', 'hdlight', 'mhd', 'hd' ],
		'HDTC' => 'HDTC', // High Definition Telecine
		'HDTV' => 'a?hd[._-]?tv(?:[._-]?rip)?',
		'HLS' => 'HLS', // HTTP Live Streaming
		'Line' => 'line(?![._-]dubbed)',
		'LP' => '\d*lp', // Vinyl Album
		'MBluray' => 'MBLURAY',
		'MDVDR' => 'MDVDR?',
		'MiniDisc' => [ 'md', 'minidisc' ],
		'MP3 CD' => '\d*mp3cd',
		'Nintendo eShop' => 'eshop', // Nintendo eShop
		'PDTV' => 'PDTV',
		'PPV' => 'PPV(?:[._-]?RIP)?', // Pay-per-view
		'PSN' => 'PSN', // Playstation Network
		'FM' => '\d*FM', // Analog Radio
		'SAT' => 'sat', // Analog Satellite
		'Scan' => 'scan',
		'SDTV' => '(?:sd)?tv(?:[._-]?rip)?',
		'SBD' => 'SBD', // Soundboard
		'Stream' => 'stream',
		'Tape' => 'tape', // Music tape
		'TC' => [ 'tc', 'telecine' ],
		'TS' => [ 'ts', 'telesync', 'pdvd' ], // ‘CAM’ video release with ‘Line’ audio synced to it.
		'UHDTV' => 'UHD[._-]?TV',
		'VHS' => 'VHS(?:[._-]?rip)?',
		'VLS' => 'vls', // Vinyl Single
		'Vinyl' => [ '(?:Complete[._-])?Vinyl', '12inch' ],
		'WEB' => 'web[._-]?(?:tv|dl|hd|rip|flac)?',
		'XBLA' => 'XBLA', // Xbox Live Arcade
		// Misc Fallback
		'CD' => [ '\d*cdr?\d*', 'cd[._-]?rom' ], // Other CD
		'DVD' => '(?:Complete[._-])?\d*dvd[_-]?[r\d]?', // Just normal DVD
		'Bluray' => [ 'blu[._-]?ray', 'bdr' ],
		'RiP' => 'rip', // If no other rip matches
	];

	// Video Encoding patterns
	// https://en.wikipedia.org/wiki/List_of_codecs#Video_compression_formats
	const FORMAT = [
		// Video formats
		'XViD' => 'XViD',
		'DiVX' => 'DiVX\d*',
		'x264' => 'x\.?264',
		'x265' => 'x\.?265',
		'h264' => 'h\.?264',
		'h265' => 'h\.?265',
		'HEVC' => 'HEVC',
		'MP4' => 'MP4',
		'MPEG' => 'MPEG',
		'MPEG2' => 'MPEG2',
		'VCD' => 'VCD',
		'CVD' => 'CVD',
		'CVCD' => 'CVCD', // Compressed Video CD
		'SVCD' => 'X?SVCD',
		'VC1' => '(?:Bluray[._-])?VC1',
		'WMV' => 'WMV',
		'MDVDR' => 'MDVDR?',
		'DVDR' => 'DVD[R\d]',
		'MBluray' => '(?:Complete[._-])?MBLURAY',
		'Bluray' => '(?:complete[._-]?)?bluray',
		'MViD' => 'MViD',
		// Ebook formats
		'AZW' => 'AZW',
		'Comic Book Archive' => 'CB[artz7]',
		'CHM' => 'CHM',
		'ePUB' => 'EPUB',
		'Hybrid' => 'HYBRID',
		'LIT' => 'LIT',
		'MOBI' => 'MOBI',
		'PDB' => 'PDB',
		'PDF' => 'PDF',
		// Music formats
		'DAISY' => 'DAISY', // Audiobook
		'FLAC' => '(?:WEB[._-]?)?FLAC',
		'KONTAKT' => 'KONTAKT',
		'MP3' => 'MP3',
		'WAV' => 'WAV',
		// Software format
		'ISO' => '(?:Bootable[._-])?ISO',
		// Font format
		'CrossPlatform' => 'Cross(?:Format|Platform)',
		'OpenType' => 'Open[._-]?Type',
		'TrueType' => 'True[._-]?Type',
		// Software/Game format
		'Java Platform, Micro Edition' => 'j2me(?:v\d*)?',
		'Java' => 'JAVA',
		// Misc
		'Multiformat' => 'MULTIFORMAT'
	];

	// Video resolution patterns
	const RESOLUTION = [
		'SD' => [ 'SD', '480p', '576p' ],
		'NTSC' => 'NTSC', // = 480p
		'PAL' => 'PAL', // = 576p
		'720p' => '720p',
		'1080i' => '1080i',
		'1080p' => '1080p',
		'2160p' => '2160p',
		'2700p' => '2700p',
		'2880p' => '2880p',
		'3072p' => '3072p',
		'3160p' => '3160p',
		'3600p' => '3600p',
		'4320p' => '4320p'
	];

	// Audio quality patterns
	const AUDIO = [
		'16BIT' => '16BIT',
		'160K' => '16\dk(?:bps)?',
		'192K' => '19\dk(?:bps)?',
		'AAC' => 'AAC\d*[._-]?\d?',
		'AC3' => 'AC3(?![._-]Dubbed)',
		'AC3D' => 'AC3D',
		'EAC3D' => 'EAC3D',
		'DD2.0' => 'dd.?2[._-]?0',
		'DD5.1' => [ 'dd.?5[._-]?1', '5[._-]1' ],
		'Dolby Digital' => 'DOLBY[._-]?DIGITAL',
		'DTS' => 'DTS[._-]?(?:HD|MA)?',
		'OGG' => 'OGG',
	];

	// Game Console patterns
	const DEVICE = [
		'3DO' => '3DO',
		'Bandai WonderSwan' => 'WS',
		'Bandai WonderSwan Color' => 'WSC',
		'Commodore Amiga' => 'AMIGA',
		'Commodore Amiga CD32' => 'CD32',
		'Commodore C64' => 'C64',
		'Commodore C264' => 'C264',
		'Nintendo DS' => 'NDS',
		'Nintendo 3DS' => '3DS',
		'Nintendo Entertainment System' => 'NES',
		'Super Nintendo Entertainment System' => 'SNES',
		'Nintendo GameBoy' => [ 'GB', 'GAMEBOY' ],
		'Nintendo GameBoy Color' => 'GBC',
		'Nintendo GameBoy Advanced' => 'GBA',
		'Nintendo Gamecube' => [ 'NGC', 'GAMECUBE' ],
		'Nintendo iQue Player' => 'iQP',
		'Nintendo Switch' => 'NSW',
		'Nintendo WII' => 'WII',
		'Nintendo WII-U' => 'WII[._-]?U',
		'NEC PC Engine' => 'PCECD',
		'Nokia N-Gage' => '(?:nokia[._-])?n[._-]?gage(?:[._-]qd)?',
		'Playstation' => 'PS[X1]?',
		'Playstation 2' => 'PS2',
		'Playstation 3' => 'PS3',
		'Playstation 4' => 'PS4',
		'Playstation 5' => 'PS5',
		'Playstation Portable' => 'PSP',
		'Playstation Vita' => 'PSV',
		'Pocket PC' => 'PPC\d*',
		'Sega Dreamcast' => [ 'DC', 'DREAMCAST' ],
		'Sega Mega CD' => 'MCD',
		'Sega Mega Drive' => 'SMD',
		'Sega Saturn' => 'SATURN',
		'Tiger Telematics Gizmondo' => 'GIZMONDO',
		'VTech V.Flash' => 'VVD',
		'Microsoft Xbox' => 'XBOX',
		'Microsoft Xbox One' => 'XBOXONE',
		'Microsoft Xbox360' => [ 'XBOX360', 'X360' ],
	];

	// Operating System patterns for Software/Game releases
	const OS = [
		'IBM AIX' => 'AIX', // Advanced Interactive eXecutive
		'Android' => 'Android',
		'BlackBerry' => 'Blackberry',
		'BSD' => '(?:Free|Net|Open)?BSD',
		'HP-UX' => 'HPUX', // Hewlett Packard Unix
		'iOS' => 'iOS',
		'Linux' => 'Linux(?:es)?',
		'macOS' => 'mac([._-]?osx?)?',
		'PalmOS' => 'Palm[._-]?OS\d*',
		'Solaris' => [ '(Open)?Solaris', 'SOL' ],
		'SunOS' => 'Sun(OS)?',
		'Symbian' => 'Symbian(?:OS\d*[._-]?\d*)?',
		'Unix'	=> 'Unix(All)?',
		'WebOS' => 'WebOS',
		// Found these hillarious (but rule conform) windows tags for software releases:
		// win9xnt2000 / WinNT2kXPvista / Win2kXP2k3Vista / winxp98nt2kse / win2kxpvista / Win2KXP2003Vista / WinXP2k3Vista2k8
		'Windows' => 'win(?:(?:[\d]+[\dxk]?|nt|all|dows|xp|vista|[msp]e)?[._-]?){0,6}',
		'Windows CE' => 'wince',
		'Windows Mobile' => 'wm\d+([._-]?se)?',
	];

	// Release language + language code patterns
	// https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
	const LANGUAGES = [
		'am' => 'Amharic',
		'ar' => 'Arabic',
		'ch' => [ 'Swiss', 'CH' ],
		'cs' => [ 'Czech', 'CZ' ],
		'cy' => 'Welsh',
		'de' => [ 'German', 'GER', 'DE' ],
		'dk' => [ 'Danish', 'DK' ],
		'el' => [ 'Greek', 'GR' ],
		'en' => [ 'English', 'VOA', 'USA', 'AUS', 'UK' ],
		'es' => [ 'Spanish', 'Espanol', 'ES', 'SPA', 'Latin[._-]Spanish' ],
		'et' => 'Estonian',
		'fa' => [ 'Persian', 'Iranian', 'IR' ],
		'fi' => 'Finnish',
		'fil' => 'Filipino',
		'fr' => [ 'French', 'Fran[cç]ais', 'TRUEFRENCH', 'VFF', '(ST|VOS)?FR[EA]?' ],
		'ga' => 'Irish',
		'he' => 'Hebrew',
		'ht' => 'Creole',
		'id' => 'Indonesian',
		'is' => 'Icelandic',
		'it' => [ 'Italian', 'ITA?' ],
		'jp' => [ 'Japanese', 'JA?PN?' ],
		'ko' => [ 'Korean', 'KOR' ],
		'km' => 'Cambodian',
		'lo' => 'Laotian',
		'lt' => [ 'Lithuanian', 'LIT' ],
		'lv' => 'Latvian',
		'mi' => 'Maori',
		'ms' => [ 'Malay', 'Malaysian' ],
		'nl' => [ 'Dutch', 'HOL', 'NL', 'Flemish' ],
		'no' => [ 'Norwegian', 'NOR?(?![._-]?\d+)' ],
		'ps' => 'Pashto',
		'pl' => [ 'Polish', 'PO?L' ],
		'pt' => [ 'Portuguese', 'PT' ],
		'pt-BR' => [ 'Brazilian', 'BR' ],
		'ro' => 'Romanian',
		'ru' => [ 'Russian', 'RU' ],
		'sv' => [ 'Swedish', 'SW?E' ],
		'sw' => 'Swahili',
		'tg' => 'Tajik',
		'th' => 'Thau',
		'tl' => 'Tagalog',
		'tr' => [ 'Turkish', 'Turk' ],
		'uk' => 'Ukrainian',
		'vi' => 'Vietnamese',
		'zh' => [ 'Chinese', 'CH[ST]' ],
		// Misc
		'multi' => [ 'Multilingual', 'Multi[._-]?(?:languages?|lang|\d*)?', 'EURO?P?A?E?', '[MD]L', 'DUAL' ],
		'nordic' => [ 'Nordic', 'SCANDiNAViAN' ]

	];

	// Release flags patterns
	const FLAGS = [
		'3D' => '3D',
		'ABook' => 'A(?:UDiO)?BOOK',
		'Abridged' => [ 'ABRIDGED', 'gekuerzte?(?:[._-](?:fassung|lesung))' ], // Audiobook
		'AC3 Dubbed' => 'ac3[._-]?dubbed',
		'Addon' => 'ADDON', // software
		'Anime' => 'ANiME',
		'ARM' => 'ARM', // software
		'Beta' => 'BETA', // software
		'Bookware' => 'BOOKWARE', // software
		'Boxset' => 'BOXSET',
		'Cheats' => 'Cheats', // games
		'Chrono' => 'CHRONO',
		'Colorized' => 'COLORIZED',
		'Comic' => 'COMIC',
		'Convert' => 'CONVERT',
		'Cover' => '(?:CUSTOM[._-]?|[a-z]+)?COVERS?',
		'Incl. Crack' => [ 'CRACK[._-]ONLY', '(?:incl|working)[._-](?:[a-zA-Z]+[._-])?crack' ], // software
		'Cracked' => 'CRACKED', // software
		'Crackfix' => 'CRACK[._-]?FIX', // software
		'Digipack' => 'DIGIPAC?K?', // music
		'DIRFiX' => 'DIR[._-]?FIX',
		'DIZFiX' => 'DIZ[._-]?FIX',
		'DLC' => '(?:incl[._-])?DLC(?![._-]?(?:Unlocker|Pack))?', // games
		'DOC' => 'D[O0][CX]',
		'Doku' => 'DOKU',
		'Dolby Vision' => 'DV',
		'Dubbed' => [ '(?<!line[._-]|mic[._-]|micro[._-]|ac3[._-]|tv[._-])Dubbed', 'E[._-]?Dubbed', '(?!over|thunder)[a-z]+dub' ],
		'eBook' => 'EBOOK',
		'Extended' => 'EXTENDED(?:[._-]CUT)?',
		'Festival' => 'FESTIVAL',
		'FiX' => '(?<!hot[._-]|sample[._-]|nfo[._-]|rar[._-]|dir[._-]|crack[._-]|sound[._-]|track[._-]|diz[._-]|menu[._-])FiX(?:[._-]?only)?',
		'Font' => '(Commercial[._-])?FONTS?',
		'Fontset' => '(Commercial[._-])?FONT[._-]?SET',
		'Fullscreen' => 'FS', // Fullscreen
		'FSK' => 'FSK', // German rating system
		'HDLIGHT' => 'HDLIGHT',
		'HDR' => 'HDR',
		'HOTFiX' => 'HOT[._-]?FIX',
		'HOU' => 'HOU',
		'HSBS' => 'HSBS',
		'Imageset' => '(?:Full[._-]?)?(?:IMA?GE?|photo|foto)[._-]?SETS?',
		'Internal' => 'iNT(ERNAL)?',
		'IVTC' => 'IVTC', // Inverce telecine
		'JAV' => 'JAV', // Japanese Adult Video
		'KEY' => 'GENERIC[._-]?KEY',
		'KEYGEN' => [ '(?:Incl[._-])?KEY(?:GEN(?:ERATOR)?|MAKER)(?:[._-]only)?', 'KEYFILE[._-]?MAKER' ],
		'Intel' => 'INTEL',
		'Line dubbed' => [ 'ld', 'line[._-]?dubbed' ],
		'Limited' => 'LIMITED',
		'Magazine' => 'MAG(AZINE)?',
		'MENUFiX' => 'MENU[._-]?FIX',
		'Micro dubbed' => [ 'md', 'mic(ro)?[._-]?dubbed' ],
		'MIPS' => 'MIPS', // software (MIPS CPU)
		'NFOFiX' => 'NFO[._-]?FiX',
		'OAR' => 'OAR', // Original Aspect Ratio
		'OVA' => 'O[AV]+', // Original Video Anime/Original Anime Video
		'OAD' => 'OAD', // Original Anime DVD
		'ONA' => 'OMA', // Original Net Animation
		'OEM' => 'OEM',
		'OST' => 'OST', // music
		//'PACK' => 'PACK',
		'Incl. Patch' => [ '(?:incl[._-])?(?:[a-z]+[._-])?patch(?:ed)?(?:[._-]only)', 'no[a-zA-Z]+[._-]patch(?:ed)?(?:[._-]only)' ], // software
		'Paysite' => 'PAYSITE', // xxx
		'Preair' => 'PREAIR',
		'PROPER' => '(?:REAL)?PROPER',
		'Promo' => 'PROMO',
		'Rated' => 'RATED',
		'RARFiX' => 'RARFIX',
		'READNFO' => 'READ[._-]?NFO',
		'REFiLL' => 'Refill',
		'Reissue' => 'REISSUE',	// music
		'REGGED' => 'REGGED',	// software
		'Remastered' => 'REMASTERED',
		'REMUX' => 'REMUX',
		'Repack' => '(working[._-])?REPACK',
		'RERiP' => 're[._-]?rip',
		'Restored' => 'RESTORED',
		'Retail' => 'RETAIL',
		'Samplefix' => 'SAMPLE[._-]?FIX',
		'SDR' => 'SDR',
		'Serial' => 'SERIAL(?![._-]Killer)?', // Software
		'SH3' => 'SH3', // software (SH3 CPU)
		'Soundfix' => 'SOUNDFIX',
		'STV' => 'STV',
		'Subbed' => [ '[a-zA-Z]*SUB(?:BED|S)?', 'SUB[._-]?\w+' ],
		'Theatrical' => 'THEATRICAL',
		'Trackfix' => 'TRACK[._-]?FiX', // Music
		'Trailer' => 'TRAILER',
		'trueHD' => 'trueHD',
		'Tutorial' => 'TUTORIAL',
		'TV Dubbed' => 'tv[._-]?dubbed',
		'UHD' => 'UHD',
		'Unabridged' => [ 'UNABRIDGED', 'Ungekuerzt' ], // Audiobook
		'Uncensored' => 'UNCENSORED',
		'Uncut' => 'UNCUT',
		'Unlicensed' => 'UNLiCENSED',
		'Unrated' => 'UNRATED',
		'Untouched' => 'UNTOUCHED',
		'USK' => 'USK', // German rating system
		'Update' => '(WITH[._-])?UPDATE',
		'VKI' => 'VKI', // Variable Keyframe Intervals
		'VR' => 'VR', // Virtual reality
		'VR180' => 'VR180',
		'Workprint' => [ 'WORKPRINT', 'WP' ],
		'Widescreen' => [ 'widescreen', 'WS' ], // Widescreen
		'x64' => 'x64', // software
		'x86' => 'x86', // software
		'XSCale' => 'Xscale', // software
		'XXX' => 'XXX'
	];

	// Format: DE + EN + NL / FR / IT / ES
	const MONTHS = [
		1 => 'Januar[iy]?|Janvier|Gennaio|Enero|Jan',
		2 => 'Februar[iy]?|Fevrier|Febbraio|Febrero|Feb',
		3 => 'Maerz|March|Moart|Mars|Marzo|Mar',
		4 => 'A[bpv]rile?|Apr',
		5 => 'M[ae][iy]|Maggio|Mayo',
		6 => 'Jun[ie]o?|Juin|Giugno|Jun',
		7 => 'Jul[iy]o?|Juillet|Luglio|Jul',
		8 => 'August|Aout|Agosto|Augustus|Aug',
		9 => 'Septemb[er][er]|Settembre|Septiembre|Sep',
		10 => 'O[ck]tob[er][er]|Ottobre|Octubre|Oct',
		11 => 'Novi?emb[er][er]|Nov',
		12 => 'D[ei][cz]i?emb[er][er]|Dec'
	];

	// Put together some flag/format arrays for better type parsing.
	// Flags
	const FLAGS_MOVIE = [ 'Dubbed', 'AC3 Dubbed', 'Line dubbed', 'Micro dubbed', 'THEATRICAL', 'UNCUT', 'Subbed' ];
	const FLAGS_EBOOK = [ 'EBOOK', 'MAGAZINE', 'COMIC', 'EPUB' ];
	const FLAGS_MUSIC = [  'OST' ];
	const FLAGS_APPS = [ 'CRACKED', 'REGGED', 'KEYGEN', 'PATCH', 'CRACKFIX', 'ISO', 'ARM', 'INTEL', 'x86', 'x64' ];
	const FLAGS_ANIME = [ 'ANIME', 'OVA', 'ONA', 'OAD' ];
	const FLAGS_XXX = [ 'XXX', 'JAV', 'Imageset' ];
	// Formats
	const FORMATS_VIDEO = [ 'VCD', 'SVCD', 'CVCD', 'XViD', 'DiVX', 'x264', 'x265', 'h264', 'h265', 'HEVC', 'MP4', 'MPEG', 'MPEG2', 'WMV' ];
	const FORMATS_MUSIC = [ 'FLAC', 'KONTAKT', 'MP3', 'OGG', 'WAV' ];
	const FORMATS_MVID = [ 'MBluray', 'MDVDR', 'MViD' ];
	// Sources
	const SOURCES_TV = [ 'ATVP', 'DSR', 'EDTV', 'HDTV', 'PDTV', 'SDTV', 'UHDTV' ];
}

/**
 * Polyfill functions.
 */

// PHP < 7.3
if ( !\function_exists( 'array_key_first' ) )
{
	function array_key_first( array $arr )
	{
		foreach( $arr as $key => $unused )
		{
			return $key;
		}
		return \null;
	}
}

if ( !\function_exists( 'array_key_last' ) )
{
	function array_key_last( array $array )
	{
		if ( !\is_array( $array ) || empty( $array ) )
		{
			return \null;
		}
		return \array_keys( $array )[ \count( $array ) - 1 ];
	}
}

// PHP < 8
if ( !\function_exists( 'str_contains' ) )
{
	function str_contains( string $haystack, string $needle )
	{
		return empty( $needle ) || \strpos( $haystack, $needle ) !== false;
	}
}
