<?php

declare(strict_types=1);

$config = [
    'host' => getenv('DB_HOST') ?: 'db',
    'port' => getenv('DB_PORT') ?: '3306',
    'name' => getenv('DB_NAME') ?: 'eyoucms123',
    'user' => getenv('DB_USER') ?: 'eyoucms',
    'pass' => getenv('DB_PASSWORD') !== false ? getenv('DB_PASSWORD') : 'eyoucms123',
    'prefix' => getenv('DB_PREFIX') ?: 'ey_',
];

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8',
    $config['host'],
    $config['port'],
    $config['name']
);

$pdo = new PDO($dsn, $config['user'], $config['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$prefix = $config['prefix'];
$now = time();

$channelStmt = $pdo->query("SELECT nid, id FROM {$prefix}channeltype WHERE nid IN ('article', 'guestbook', 'download')");
$channelIds = [];
foreach ($channelStmt as $row) {
    $channelIds[$row['nid']] = (int) $row['id'];
}

if (empty($channelIds['article']) || empty($channelIds['guestbook']) || empty($channelIds['download'])) {
    throw new RuntimeException('Missing required EyouCMS channel types.');
}

$newsTypeId = 1;
$messageTypeId = 2;
$downloadTypeId = 3;
$videoTypeId = 4;
$newsKeywords = 'woven packaging machinery, PP woven bag making machine, woven bag production line, industrial bag making machine, turnkey woven bag production line';
$downloadKeywords = 'woven packaging machinery, block bottom valve bag making machine, PP woven bag making machine, woven sack conversion line, PP woven fabric coating machine';
$videoKeywords = 'block bottom valve bag making machine video, woven bag production line video, industrial bag making machine video, PP woven sack production line video, woven packaging machinery video';

$articles = [
    [
        'slug' => 'technical-baseline-bvm-120',
        'title' => 'Technical baseline released for BVM-120',
        'description' => 'The BVM-120 technical baseline has been organized around max speed, typical production output, sack width, bottom width, and total power.',
        'keywords' => 'block bottom valve bag making machine, woven valve bag making machine, valve sack production line, industrial bag making machine, woven sack conversion line',
        'image' => '/images/banner01.png',
        'date' => '2026-05-06 10:00:00',
        'lead' => 'The updated baseline makes it easier for customers to evaluate whether the BVM-120 matches their block bottom valve bag production plan.',
        'paragraphs' => [
            'Key reference data includes up to 120 bags/min maximum speed, 90-115 bags/min typical production range, 350-600 mm sack width, 80-160 mm bottom width, and 120 kW total power.',
            'The information also helps the sales and engineering teams align quotations, site planning, and technical communication around the same parameter set.',
        ],
        'note' => 'This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.',
    ],
    [
        'slug' => 'application-notes-laminated-pp',
        'title' => 'Application notes updated for laminated PP workflow',
        'description' => 'Application notes for laminated PP tubular fabric, valve patch, and bottom patch process matching have been updated.',
        'keywords' => 'PP woven fabric coating machine, woven fabric lamination line, lamination machine for woven bags, BOPP lamination machine, BOPP laminated woven bag',
        'image' => '/images/p1.jpg',
        'date' => '2026-04-28 10:00:00',
        'lead' => 'The updated notes focus on material matching, feeding stability, patch positioning, and sealing reliability.',
        'paragraphs' => [
            'For laminated PP workflows, consistent fabric quality and patch preparation are important for stable forming and finished bag strength.',
            'These notes support early-stage project evaluation before final line configuration and commissioning.',
        ],
        'note' => 'This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.',
    ],
    [
        'slug' => 'delivery-workflow-global-installations',
        'title' => 'Delivery workflow refined for global installations',
        'description' => 'The installation, commissioning, and post-start service workflow has been refined for global customers.',
        'keywords' => 'turnkey woven bag production line, woven packaging machinery, bulk packaging production line, industrial bag making machine, PP woven sack production line',
        'image' => '/images/home.jpg',
        'date' => '2026-04-16 10:00:00',
        'lead' => 'The delivery workflow now places more emphasis on pre-shipment checks, installation planning, operator training, and early production support.',
        'paragraphs' => [
            'This makes each project easier to coordinate from factory acceptance through production start-up.',
            'The goal is to reduce uncertainty during handover and help customers reach stable output faster.',
        ],
        'note' => 'This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.',
    ],
    [
        'slug' => 'control-system-diagnostics-upgrade',
        'title' => 'Control system diagnostics package upgraded',
        'description' => 'HMI monitoring and fault tracking templates have been improved for easier daily operation and maintenance.',
        'keywords' => 'industrial bag making machine, woven bag production line, PP woven bag conversion machine, woven sack conversion line, turnkey woven bag production line',
        'image' => '/images/p2.jpg',
        'date' => '2026-03-29 10:00:00',
        'lead' => 'The upgraded diagnostics package helps operators identify abnormal conditions faster and supports more consistent maintenance routines.',
        'paragraphs' => [
            'HMI visibility is especially useful for coordinated modules such as feeding, forming, patch pressing, counting, and reject control.',
            'The update supports better communication between operation teams and service engineers.',
        ],
        'note' => 'This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.',
    ],
    [
        'slug' => 'material-requirement-checklist',
        'title' => 'Material requirement checklist standardized',
        'description' => 'A standardized material checklist now covers fabric, patch, width, and process readiness requirements.',
        'keywords' => 'PP woven fabric coating machine, woven sack conversion line, woven bag production line, laminated woven bag machine, industrial bag making machine',
        'image' => '/images/img01.jpg',
        'date' => '2026-03-02 10:00:00',
        'lead' => 'Material preparation has a direct impact on forming quality, sealing consistency, and finished bag performance.',
        'paragraphs' => [
            'The checklist helps customers prepare key material data before technical evaluation and production trials.',
            'It also reduces repeated communication during project setup and improves engineering response speed.',
        ],
        'note' => 'This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.',
    ],
    [
        'slug' => 'multi-size-open-mouth-line-deployment',
        'title' => 'New case: multi-size open-mouth line deployment',
        'description' => 'A new deployment case highlights module reconfiguration for multi-size open-mouth bag production.',
        'keywords' => 'open mouth bag making machine, woven open mouth bag conversion line, PP open mouth bag machine, sewn open mouth sack machine, open top sack production line',
        'image' => '/images/p1.jpg',
        'date' => '2026-02-14 10:00:00',
        'lead' => 'The project focused on flexible changeover, line stability, and consistent output across several bag specifications.',
        'paragraphs' => [
            'Module-level adjustment guidance helped the customer move between production plans with less uncertainty.',
            'This case will be used as a reference for future multi-size industrial packaging projects.',
        ],
        'note' => 'This update helps customers evaluate equipment configuration, process readiness, and service planning with clearer technical context.',
    ],
];

$guestbookFields = [
    [
        'attr_id' => 1,
        'attr_name' => 'Name',
        'attr_input_type' => 0,
        'required' => 0,
        'validate_type' => 0,
        'sort_order' => 10,
    ],
    [
        'attr_id' => 2,
        'attr_name' => 'Phone',
        'attr_input_type' => 0,
        'required' => 1,
        'validate_type' => 0,
        'sort_order' => 20,
    ],
    [
        'attr_id' => 3,
        'attr_name' => 'E-mail',
        'attr_input_type' => 7,
        'required' => 1,
        'validate_type' => 7,
        'sort_order' => 30,
    ],
    [
        'attr_id' => 4,
        'attr_name' => 'WhatsApp',
        'attr_input_type' => 0,
        'required' => 0,
        'validate_type' => 0,
        'sort_order' => 40,
    ],
    [
        'attr_id' => 5,
        'attr_name' => 'Message',
        'attr_input_type' => 2,
        'required' => 1,
        'validate_type' => 0,
        'sort_order' => 50,
    ],
];

$downloads = [
    [
        'slug' => 'liguoxing-brochure',
        'title' => 'Company Brochure (PDF)',
        'description' => 'Overview of company capability and product direction.',
        'keywords' => 'woven packaging machinery, woven bag production line, industrial bag making machine, PP woven sack production line, bulk packaging production line',
        'file_url' => '/docs/liguoxing-brochure.pdf',
        'date' => '2026-05-01 09:00:00',
    ],
    [
        'slug' => 'bvm-120-technical-profile',
        'title' => 'BVM-120 Technical Profile (PDF)',
        'description' => 'Machine profile for block bottom valve bag production.',
        'keywords' => 'block bottom valve bag making machine, cement valve bag making machine, woven valve bag making machine, valve sack production line, woven sack conversion line',
        'file_url' => '/docs/bvm-120-block-bottom-valve-bag-machine.pdf',
        'date' => '2026-04-24 09:00:00',
    ],
    [
        'slug' => 'valve-bag-introduction',
        'title' => 'Valve Bag Introduction (PDF)',
        'description' => 'General introduction of block bottom valve bag process and application value.',
        'keywords' => 'block bottom valve bag, block bottom valve sack, woven valve bag making machine, cement packaging bag machine, valve sack production line',
        'file_url' => '/docs/block-bottom-valve-bag-introduction.pdf',
        'date' => '2026-04-10 09:00:00',
    ],
    [
        'slug' => 'block-bottom-technical-document',
        'title' => 'Technical Document (DOCX)',
        'description' => 'Detailed technical configuration and module description.',
        'keywords' => 'block bottom valve bag making machine, PP woven bag conversion machine, woven sack conversion line, industrial bag making machine, turnkey woven bag production line',
        'file_url' => '/docs/block-bottom-valve-bag-machine.docx',
        'date' => '2026-03-28 09:00:00',
    ],
    [
        'slug' => 'technical-presentation',
        'title' => 'Technical Presentation (PPTX)',
        'description' => 'Process explanation slides for project discussions.',
        'keywords' => 'woven packaging machinery, block bottom valve bag making machine, PP woven bag making machine, woven sack conversion line, industrial bag making machine',
        'file_url' => '/docs/technical-presentation.pptx',
        'date' => '2026-03-15 09:00:00',
    ],
];

$videos = [
    [
        'slug' => 'liguoxing-company-profile',
        'title' => 'LIGUOXING Company Profile',
        'subtitle' => 'Company introduction and factory capability overview.',
        'description' => 'A quick look at LIGUOXING manufacturing capability, workshop resources, and project delivery support.',
        'keywords' => 'woven packaging machinery video, industrial bag making machine video, woven bag production line video, PP woven sack production line video, turnkey woven bag production line',
        'youtube_url' => 'https://www.youtube.com/watch?v=nhc7cRXHB5g',
        'date' => '2026-05-10 10:00:00',
        'lead' => 'This company profile video introduces the production environment, machining capability, and export-oriented service support behind LIGUOXING equipment.',
        'paragraphs' => [
            'It gives customers a quick way to understand factory scale, process control, and the engineering background behind turnkey woven packaging projects.',
            'The video is useful for early-stage introductions, distributor communication, and customer presentation scenarios.',
        ],
    ],
    [
        'slug' => 'bvm-120-running-demo',
        'title' => 'BVM-120 Running Demonstration',
        'subtitle' => 'Live production view of the block bottom valve bag making line.',
        'description' => 'Production footage of the BVM-120 showing forming, welding, and finished bag output in operation.',
        'keywords' => 'block bottom valve bag making machine video, cement valve bag making machine video, woven valve bag making machine video, valve sack production line video, woven sack conversion line video',
        'youtube_url' => 'https://www.youtube.com/watch?v=12BZUHSFseM',
        'date' => '2026-05-08 10:00:00',
        'lead' => 'This running demo focuses on actual machine movement, process coordination, and finished bag output on the BVM-120 platform.',
        'paragraphs' => [
            'It helps customers evaluate equipment rhythm, forming stability, and the practical layout of the production section.',
            'The footage is useful for technical review, proposal support, and internal customer discussions before project confirmation.',
        ],
    ],
];

function slugifyTitle(string $title, string $fallbackPrefix, int $id): string
{
    $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title);
    if ($ascii === false) {
        $ascii = $title;
    }

    $slug = strtolower(trim((string) preg_replace('/[^a-zA-Z0-9]+/', '-', $ascii), '-'));
    if ($slug === '' || preg_match('/^\d+$/', $slug)) {
        $slug = $fallbackPrefix . '-' . $id;
    }

    return $slug;
}

function uniqueSlug(PDO $pdo, string $table, string $prefixName, int $typeid, int $aid, string $title): string
{
    $slug = slugifyTitle($title, $prefixName, $aid);
    $baseSlug = $slug;
    $index = 1;

    while (true) {
        $stmt = $pdo->prepare("SELECT aid FROM {$table} WHERE typeid = :typeid AND htmlfilename = :htmlfilename AND aid <> :aid LIMIT 1");
        $stmt->execute([
            'typeid' => $typeid,
            'htmlfilename' => $slug,
            'aid' => $aid,
        ]);
        if (!$stmt->fetchColumn()) {
            return $slug;
        }
        $slug = $baseSlug . '-' . $index;
        ++$index;
    }
}

function columnExists(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare("SHOW COLUMNS FROM {$table} LIKE :column");
    $stmt->execute(['column' => $column]);

    return (bool) $stmt->fetchColumn();
}

function extractYouTubeVideoId(string $url): string
{
    $url = trim($url);
    if ($url === '') {
        return '';
    }

    $patterns = [
        '~youtu\.be/([A-Za-z0-9_-]{11})~',
        '~youtube\.com/watch\?[^#]*v=([A-Za-z0-9_-]{11})~',
        '~youtube\.com/embed/([A-Za-z0-9_-]{11})~',
        '~youtube\.com/shorts/([A-Za-z0-9_-]{11})~',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
    }

    return preg_match('/^[A-Za-z0-9_-]{11}$/', $url) ? $url : '';
}

function buildYouTubeThumbnail(string $url): string
{
    $videoId = extractYouTubeVideoId($url);
    return $videoId !== '' ? 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg' : '';
}

function buildArticleContent(array $article): string
{
    $parts = [
        '<p class="lead">' . htmlspecialchars($article['lead'], ENT_QUOTES, 'UTF-8') . '</p>',
    ];

    foreach ($article['paragraphs'] as $paragraph) {
        $parts[] = '<p>' . htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8') . '</p>';
    }

    $parts[] = '<div class="detail-note"><h2>What This Means</h2><p>' .
        htmlspecialchars($article['note'], ENT_QUOTES, 'UTF-8') .
        '</p></div>';

    return implode("\n", $parts);
}

function buildVideoContent(array $video): string
{
    $parts = [
        '<p class="lead">' . htmlspecialchars($video['lead'], ENT_QUOTES, 'UTF-8') . '</p>',
    ];

    foreach ($video['paragraphs'] as $paragraph) {
        $parts[] = '<p>' . htmlspecialchars($paragraph, ENT_QUOTES, 'UTF-8') . '</p>';
    }

    return implode("\n", $parts);
}

$pdo->beginTransaction();

try {
    if (!columnExists($pdo, "{$prefix}article_content", 'youtube_url')) {
        $pdo->exec("ALTER TABLE {$prefix}article_content ADD COLUMN youtube_url varchar(500) NOT NULL DEFAULT '' AFTER content_ey_m");
    }

    $youtubeFieldExistsStmt = $pdo->prepare("SELECT id FROM {$prefix}channelfield WHERE channel_id = :channel_id AND name = 'youtube_url' LIMIT 1");
    $youtubeFieldExistsStmt->execute(['channel_id' => $channelIds['article']]);
    if (!$youtubeFieldExistsStmt->fetchColumn()) {
        $insertYoutubeFieldStmt = $pdo->prepare(
            "INSERT INTO {$prefix}channelfield
                (name, channel_id, title, dtype, define, maxlength, dfvalue, dfvalue_unit, remark, is_screening, is_release, ifeditable, ifrequire, ifsystem, ifmain, ifcontrol, sort_order, status, add_time, update_time, set_type)
             VALUES
                ('youtube_url', :channel_id, 'YouTube URL', 'text', '', 500, '', '', 'Paste a full YouTube link.', 0, 0, 1, 1, 0, 0, 1, 120, 1, :add_time, :update_time, 0)"
        );
        $insertYoutubeFieldStmt->execute([
            'channel_id' => $channelIds['article'],
            'add_time' => $now,
            'update_time' => $now,
        ]);
    }

    $arctypeSql = <<<SQL
INSERT INTO {$prefix}arctype
    (id, channeltype, current_channel, parent_id, topid, typename, dirname, dirpath, diy_dirpath, rulelist, ruleview, grade, templist, tempview, seo_title, seo_keywords, seo_description, sort_order, is_hidden, is_part, admin_id, is_del, del_method, status, is_release, lang, add_time, update_time, target, nofollow, typearcrank, empty_logic, page_limit, total_arc)
VALUES
    (:id, :channeltype, :current_channel, :parent_id, :topid, :typename, :dirname, :dirpath, :diy_dirpath, :rulelist, :ruleview, :grade, :templist, :tempview, :seo_title, :seo_keywords, :seo_description, :sort_order, :is_hidden, :is_part, :admin_id, :is_del, :del_method, :status, :is_release, :lang, :add_time, :update_time, :target, :nofollow, :typearcrank, :empty_logic, :page_limit, :total_arc)
ON DUPLICATE KEY UPDATE
    channeltype = VALUES(channeltype),
    current_channel = VALUES(current_channel),
    parent_id = VALUES(parent_id),
    topid = VALUES(topid),
    typename = VALUES(typename),
    dirname = VALUES(dirname),
    dirpath = VALUES(dirpath),
    diy_dirpath = VALUES(diy_dirpath),
    rulelist = VALUES(rulelist),
    ruleview = VALUES(ruleview),
    grade = VALUES(grade),
    templist = VALUES(templist),
    tempview = VALUES(tempview),
    seo_title = VALUES(seo_title),
    seo_keywords = VALUES(seo_keywords),
    seo_description = VALUES(seo_description),
    sort_order = VALUES(sort_order),
    is_hidden = VALUES(is_hidden),
    is_part = VALUES(is_part),
    admin_id = VALUES(admin_id),
    is_del = VALUES(is_del),
    del_method = VALUES(del_method),
    status = VALUES(status),
    is_release = VALUES(is_release),
    lang = VALUES(lang),
    update_time = VALUES(update_time),
    target = VALUES(target),
    nofollow = VALUES(nofollow),
    typearcrank = VALUES(typearcrank),
    empty_logic = VALUES(empty_logic),
    page_limit = VALUES(page_limit),
    total_arc = VALUES(total_arc)
SQL;
    $arctypeStmt = $pdo->prepare($arctypeSql);

    $arctypeStmt->execute([
        'id' => $newsTypeId,
        'channeltype' => $channelIds['article'],
        'current_channel' => $channelIds['article'],
        'parent_id' => 0,
        'topid' => $newsTypeId,
        'typename' => 'News',
        'dirname' => 'news',
        'dirpath' => '/news',
        'diy_dirpath' => 'news',
        'rulelist' => 'news.htm',
        'ruleview' => 'news/{aid}.htm',
        'grade' => 1,
        'templist' => 'news.htm',
        'tempview' => 'news_detail.htm',
        'seo_title' => 'Latest News | LIGUOXING',
        'seo_keywords' => $newsKeywords,
        'seo_description' => 'LIGUOXING technical, delivery, application, and service updates for industrial bag making equipment.',
        'sort_order' => 100,
        'is_hidden' => 0,
        'is_part' => 0,
        'admin_id' => 1,
        'is_del' => 0,
        'del_method' => 0,
        'status' => 1,
        'is_release' => 0,
        'lang' => 'cn',
        'add_time' => $now,
        'update_time' => $now,
        'target' => 0,
        'nofollow' => 0,
        'typearcrank' => 0,
        'empty_logic' => 0,
        'page_limit' => '',
        'total_arc' => count($articles),
    ]);

    $arctypeStmt->execute([
        'id' => $messageTypeId,
        'channeltype' => $channelIds['guestbook'],
        'current_channel' => $channelIds['guestbook'],
        'parent_id' => 0,
        'topid' => $messageTypeId,
        'typename' => 'Message',
        'dirname' => 'message',
        'dirpath' => '/message',
        'diy_dirpath' => 'message',
        'rulelist' => 'message.htm',
        'ruleview' => '',
        'grade' => 1,
        'templist' => '',
        'tempview' => '',
        'seo_title' => 'Message',
        'seo_keywords' => 'message, inquiry, liguoxing',
        'seo_description' => 'Business inquiry form configuration for LIGUOXING.',
        'sort_order' => 90,
        'is_hidden' => 1,
        'is_part' => 0,
        'admin_id' => 1,
        'is_del' => 0,
        'del_method' => 0,
        'status' => 1,
        'is_release' => 0,
        'lang' => 'cn',
        'add_time' => $now,
        'update_time' => $now,
        'target' => 0,
        'nofollow' => 0,
        'typearcrank' => 0,
        'empty_logic' => 0,
        'page_limit' => '',
        'total_arc' => 0,
    ]);

    $arctypeStmt->execute([
        'id' => $downloadTypeId,
        'channeltype' => $channelIds['download'],
        'current_channel' => $channelIds['download'],
        'parent_id' => 0,
        'topid' => $downloadTypeId,
        'typename' => 'Download',
        'dirname' => 'download',
        'dirpath' => '/download',
        'diy_dirpath' => 'download',
        'rulelist' => 'download.htm',
        'ruleview' => 'download/{aid}.htm',
        'grade' => 1,
        'templist' => 'download.htm',
        'tempview' => 'download_detail.htm',
        'seo_title' => 'Download | LIGUOXING',
        'seo_keywords' => $downloadKeywords,
        'seo_description' => 'Download brochures, technical profiles, and process documents for project communication.',
        'sort_order' => 80,
        'is_hidden' => 0,
        'is_part' => 0,
        'admin_id' => 1,
        'is_del' => 0,
        'del_method' => 0,
        'status' => 1,
        'is_release' => 0,
        'lang' => 'cn',
        'add_time' => $now,
        'update_time' => $now,
        'target' => 0,
        'nofollow' => 0,
        'typearcrank' => 0,
        'empty_logic' => 0,
        'page_limit' => '',
        'total_arc' => count($downloads),
    ]);

    $arctypeStmt->execute([
        'id' => $videoTypeId,
        'channeltype' => $channelIds['article'],
        'current_channel' => $channelIds['article'],
        'parent_id' => 0,
        'topid' => $videoTypeId,
        'typename' => 'Video',
        'dirname' => 'video',
        'dirpath' => '/video',
        'diy_dirpath' => 'video',
        'rulelist' => 'video.htm',
        'ruleview' => 'video/{aid}.htm',
        'grade' => 1,
        'templist' => 'video.htm',
        'tempview' => 'video_detail.htm',
        'seo_title' => 'Video | LIGUOXING',
        'seo_keywords' => $videoKeywords,
        'seo_description' => 'Video list for LIGUOXING equipment demonstrations, factory introductions, and project presentation clips.',
        'sort_order' => 85,
        'is_hidden' => 0,
        'is_part' => 0,
        'admin_id' => 1,
        'is_del' => 0,
        'del_method' => 0,
        'status' => 1,
        'is_release' => 0,
        'lang' => 'cn',
        'add_time' => $now,
        'update_time' => $now,
        'target' => 0,
        'nofollow' => 0,
        'typearcrank' => 0,
        'empty_logic' => 0,
        'page_limit' => '',
        'total_arc' => count($videos),
    ]);

    $pdo->prepare("DELETE FROM {$prefix}guestbook_attribute WHERE typeid = :typeid AND form_type = 0")
        ->execute(['typeid' => $messageTypeId]);

    $guestbookStmt = $pdo->prepare(
        "INSERT INTO {$prefix}guestbook_attribute
            (attr_id, attr_name, typeid, form_type, attr_input_type, attr_values, is_showlist, required, validate_type, real_validate, sort_order, lang, is_del, add_time, update_time)
         VALUES
            (:attr_id, :attr_name, :typeid, 0, :attr_input_type, '', 1, :required, :validate_type, 0, :sort_order, 'cn', 0, :add_time, :update_time)"
    );

    foreach ($guestbookFields as $field) {
        $guestbookStmt->execute([
            'attr_id' => $field['attr_id'],
            'attr_name' => $field['attr_name'],
            'typeid' => $messageTypeId,
            'attr_input_type' => $field['attr_input_type'],
            'required' => $field['required'],
            'validate_type' => $field['validate_type'],
            'sort_order' => $field['sort_order'],
            'add_time' => $now,
            'update_time' => $now,
        ]);
    }

    $findArchiveStmt = $pdo->prepare("SELECT aid FROM {$prefix}archives WHERE typeid = :typeid AND htmlfilename = :htmlfilename LIMIT 1");
    $insertArchiveStmt = $pdo->prepare(
        "INSERT INTO {$prefix}archives
            (typeid, stypeid, channel, is_b, title, subtitle, introduction, litpic, is_head, is_special, is_top, is_recom, is_jump, is_litpic, is_roll, is_slide, is_diyattr, origin, author, click, arcrank, jumplinks, ismake, seo_title, seo_keywords, seo_description, attrlist_id, merchant_id, free_shipping, users_price, crossed_price, users_discount_type, users_free, old_price, sales_num, virtual_sales, sales_all, stock_count, stock_show, prom_type, logistics_type, tempview, status, sort_order, lang, admin_id, users_id, arc_level_id, restric_type, users_score, is_del, del_method, joinaid, downcount, appraise, collection, htmlfilename, province_id, city_id, area_id, add_time, update_time, removal_time, no_vip_pay, editor_remote_img_local, editor_img_clear_link, editor_ai_create)
         VALUES
            (:typeid, '', :channel, 0, :title, :subtitle, :introduction, :litpic, 0, 0, 0, 0, 0, :is_litpic, 0, 0, 0, '', 'LIGUOXING', 0, 0, :jumplinks, 0, :seo_title, :seo_keywords, :seo_description, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '1', :tempview, 1, :sort_order, 'cn', 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, :htmlfilename, 0, 0, 0, :add_time, :update_time, 0, 0, 1, 1, 0)"
    );
    $updateArchiveStmt = $pdo->prepare(
        "UPDATE {$prefix}archives
            SET typeid = :typeid,
                channel = :channel,
                title = :title,
                subtitle = :subtitle,
                introduction = :introduction,
                litpic = :litpic,
                is_litpic = :is_litpic,
                jumplinks = :jumplinks,
                seo_title = :seo_title,
                seo_keywords = :seo_keywords,
                seo_description = :seo_description,
                tempview = :tempview,
                status = 1,
                sort_order = :sort_order,
                admin_id = 1,
                htmlfilename = :htmlfilename,
                add_time = :add_time,
                update_time = :update_time
          WHERE aid = :aid"
    );
    $findContentStmt = $pdo->prepare("SELECT id FROM {$prefix}article_content WHERE aid = :aid LIMIT 1");
    $insertContentStmt = $pdo->prepare(
        "INSERT INTO {$prefix}article_content (aid, content, content_ey_m, add_time, update_time)
         VALUES (:aid, :content, '', :add_time, :update_time)"
    );
    $updateContentStmt = $pdo->prepare(
        "UPDATE {$prefix}article_content
            SET content = :content,
                update_time = :update_time
          WHERE aid = :aid"
    );
    $insertVideoContentStmt = $pdo->prepare(
        "INSERT INTO {$prefix}article_content (aid, content, content_ey_m, youtube_url, add_time, update_time)
         VALUES (:aid, :content, '', :youtube_url, :add_time, :update_time)"
    );
    $updateVideoContentStmt = $pdo->prepare(
        "UPDATE {$prefix}article_content
            SET content = :content,
                youtube_url = :youtube_url,
                update_time = :update_time
          WHERE aid = :aid"
    );

    $sortOrder = count($articles);
    foreach ($articles as $article) {
        $timestamp = strtotime($article['date']);
        $content = buildArticleContent($article);
        $payload = [
            'typeid' => $newsTypeId,
            'channel' => $channelIds['article'],
            'title' => $article['title'],
            'subtitle' => '',
            'introduction' => $article['description'],
            'litpic' => $article['image'],
            'is_litpic' => $article['image'] !== '' ? 1 : 0,
            'jumplinks' => '',
            'seo_title' => $article['title'] . ' | News | LIGUOXING',
            'seo_keywords' => $article['keywords'],
            'seo_description' => $article['description'],
            'tempview' => 'news_detail.htm',
            'sort_order' => $sortOrder--,
            'htmlfilename' => $article['slug'],
            'add_time' => $timestamp,
            'update_time' => $timestamp,
        ];

        $findArchiveStmt->execute([
            'typeid' => $newsTypeId,
            'htmlfilename' => $article['slug'],
        ]);
        $existingAid = $findArchiveStmt->fetchColumn();

        if ($existingAid) {
            $payload['aid'] = (int) $existingAid;
            $updateArchiveStmt->execute($payload);
            $aid = (int) $existingAid;
        } else {
            $insertArchiveStmt->execute($payload);
            $aid = (int) $pdo->lastInsertId();
        }

        $findContentStmt->execute(['aid' => $aid]);
        $contentExists = $findContentStmt->fetchColumn();
        if ($contentExists) {
            $updateContentStmt->execute([
                'aid' => $aid,
                'content' => $content,
                'update_time' => $timestamp,
            ]);
        } else {
            $insertContentStmt->execute([
                'aid' => $aid,
                'content' => $content,
                'add_time' => $timestamp,
                'update_time' => $timestamp,
            ]);
        }
    }

    $findDownloadStmt = $pdo->prepare("SELECT aid FROM {$prefix}archives WHERE typeid = :typeid AND htmlfilename = :htmlfilename LIMIT 1");
    $findDownloadContentStmt = $pdo->prepare("SELECT id FROM {$prefix}download_content WHERE aid = :aid LIMIT 1");
    $insertDownloadContentStmt = $pdo->prepare(
        "INSERT INTO {$prefix}download_content (aid, content, content_ey_m, add_time, update_time)
         VALUES (:aid, :content, '', :add_time, :update_time)"
    );
    $updateDownloadContentStmt = $pdo->prepare(
        "UPDATE {$prefix}download_content
            SET content = :content,
                update_time = :update_time
          WHERE aid = :aid"
    );
    $deleteDownloadFilesStmt = $pdo->prepare("DELETE FROM {$prefix}download_file WHERE aid = :aid");
    $insertDownloadFileStmt = $pdo->prepare(
        "INSERT INTO {$prefix}download_file
            (aid, title, file_url, extract_code, file_size, file_ext, file_name, server_name, file_mime, uhash, md5file, is_remote, downcount, sort_order, add_time, update_time)
         VALUES
            (:aid, :title, :file_url, '', '0', :file_ext, :file_name, :server_name, '', :uhash, :md5file, 0, 0, 1, :add_time, :update_time)"
    );

    $sortOrder = count($downloads);
    foreach ($downloads as $download) {
        $timestamp = strtotime($download['date']);
        $content = '<p>' . htmlspecialchars($download['description'], ENT_QUOTES, 'UTF-8') . '</p>';
        $payload = [
            'typeid' => $downloadTypeId,
            'channel' => $channelIds['download'],
            'title' => $download['title'],
            'subtitle' => '',
            'introduction' => $download['description'],
            'litpic' => '',
            'is_litpic' => 0,
            'jumplinks' => '',
            'seo_title' => $download['title'] . ' | Download | LIGUOXING',
            'seo_keywords' => $download['keywords'],
            'seo_description' => $download['description'],
            'tempview' => 'download_detail.htm',
            'sort_order' => $sortOrder--,
            'htmlfilename' => $download['slug'],
            'add_time' => $timestamp,
            'update_time' => $timestamp,
        ];

        $findDownloadStmt->execute([
            'typeid' => $downloadTypeId,
            'htmlfilename' => $download['slug'],
        ]);
        $existingAid = $findDownloadStmt->fetchColumn();

        if ($existingAid) {
            $payload['aid'] = (int) $existingAid;
            $updateArchiveStmt->execute($payload);
            $aid = (int) $existingAid;
        } else {
            $insertArchiveStmt->execute($payload);
            $aid = (int) $pdo->lastInsertId();
        }

        $findDownloadContentStmt->execute(['aid' => $aid]);
        $contentExists = $findDownloadContentStmt->fetchColumn();
        if ($contentExists) {
            $updateDownloadContentStmt->execute([
                'aid' => $aid,
                'content' => $content,
                'update_time' => $timestamp,
            ]);
        } else {
            $insertDownloadContentStmt->execute([
                'aid' => $aid,
                'content' => $content,
                'add_time' => $timestamp,
                'update_time' => $timestamp,
            ]);
        }

        $deleteDownloadFilesStmt->execute(['aid' => $aid]);
        $fileExt = strtolower(pathinfo($download['file_url'], PATHINFO_EXTENSION));
        $fileName = basename($download['file_url']);
        $insertDownloadFileStmt->execute([
            'aid' => $aid,
            'title' => $download['title'],
            'file_url' => $download['file_url'],
            'file_ext' => $fileExt,
            'file_name' => $fileName,
            'server_name' => $download['title'],
            'uhash' => md5($download['file_url']),
            'md5file' => md5($download['file_url']),
            'add_time' => $timestamp,
            'update_time' => $timestamp,
        ]);
    }

    $sortOrder = count($videos);
    foreach ($videos as $video) {
        $timestamp = strtotime($video['date']);
        $content = buildVideoContent($video);
        $thumbnail = buildYouTubeThumbnail($video['youtube_url']);
        $payload = [
            'typeid' => $videoTypeId,
            'channel' => $channelIds['article'],
            'title' => $video['title'],
            'subtitle' => $video['subtitle'],
            'introduction' => $video['description'],
            'litpic' => $thumbnail,
            'is_litpic' => $thumbnail !== '' ? 1 : 0,
            'jumplinks' => $video['youtube_url'],
            'seo_title' => $video['title'] . ' | Video | LIGUOXING',
            'seo_keywords' => $video['keywords'],
            'seo_description' => $video['description'],
            'tempview' => 'video_detail.htm',
            'sort_order' => $sortOrder--,
            'htmlfilename' => $video['slug'],
            'add_time' => $timestamp,
            'update_time' => $timestamp,
        ];

        $findArchiveStmt->execute([
            'typeid' => $videoTypeId,
            'htmlfilename' => $video['slug'],
        ]);
        $existingAid = $findArchiveStmt->fetchColumn();

        if ($existingAid) {
            $payload['aid'] = (int) $existingAid;
            $updateArchiveStmt->execute($payload);
            $aid = (int) $existingAid;
        } else {
            $insertArchiveStmt->execute($payload);
            $aid = (int) $pdo->lastInsertId();
        }

        $findContentStmt->execute(['aid' => $aid]);
        $contentExists = $findContentStmt->fetchColumn();
        if ($contentExists) {
            $updateVideoContentStmt->execute([
                'aid' => $aid,
                'content' => $content,
                'youtube_url' => $video['youtube_url'],
                'update_time' => $timestamp,
            ]);
        } else {
            $insertVideoContentStmt->execute([
                'aid' => $aid,
                'content' => $content,
                'youtube_url' => $video['youtube_url'],
                'add_time' => $timestamp,
                'update_time' => $timestamp,
            ]);
        }
    }

    $normalizeStmt = $pdo->prepare("SELECT aid, title, htmlfilename, tempview FROM {$prefix}archives WHERE typeid = :typeid ORDER BY aid ASC");
    $normalizeUpdateStmt = $pdo->prepare("UPDATE {$prefix}archives SET htmlfilename = :htmlfilename, tempview = :tempview, update_time = :update_time WHERE aid = :aid");

    $normalizeStmt->execute(['typeid' => $newsTypeId]);
    foreach ($normalizeStmt->fetchAll() as $row) {
        $htmlfilename = (string) $row['htmlfilename'];
        if ($htmlfilename === '') {
            $htmlfilename = uniqueSlug($pdo, "{$prefix}archives", 'news', $newsTypeId, (int) $row['aid'], (string) $row['title']);
        }
        $tempview = (string) $row['tempview'];
        if ($tempview === '' || $tempview === 'view_article.htm') {
            $tempview = 'news_detail.htm';
        }
        $normalizeUpdateStmt->execute([
            'aid' => (int) $row['aid'],
            'htmlfilename' => $htmlfilename,
            'tempview' => $tempview,
            'update_time' => $now,
        ]);
    }

    $normalizeStmt->execute(['typeid' => $downloadTypeId]);
    foreach ($normalizeStmt->fetchAll() as $row) {
        $htmlfilename = (string) $row['htmlfilename'];
        if ($htmlfilename === '') {
            $htmlfilename = uniqueSlug($pdo, "{$prefix}archives", 'download', $downloadTypeId, (int) $row['aid'], (string) $row['title']);
        }
        $tempview = (string) $row['tempview'];
        if ($tempview === '' || $tempview === 'view_download.htm') {
            $tempview = 'download_detail.htm';
        }
        $normalizeUpdateStmt->execute([
            'aid' => (int) $row['aid'],
            'htmlfilename' => $htmlfilename,
            'tempview' => $tempview,
            'update_time' => $now,
        ]);
    }

    $normalizeStmt->execute(['typeid' => $videoTypeId]);
    foreach ($normalizeStmt->fetchAll() as $row) {
        $htmlfilename = (string) $row['htmlfilename'];
        if ($htmlfilename === '') {
            $htmlfilename = uniqueSlug($pdo, "{$prefix}archives", 'video', $videoTypeId, (int) $row['aid'], (string) $row['title']);
        }
        $tempview = (string) $row['tempview'];
        if ($tempview === '' || $tempview === 'view_article.htm') {
            $tempview = 'video_detail.htm';
        }
        $normalizeUpdateStmt->execute([
            'aid' => (int) $row['aid'],
            'htmlfilename' => $htmlfilename,
            'tempview' => $tempview,
            'update_time' => $now,
        ]);
    }

    $pdo->prepare("UPDATE {$prefix}arctype SET total_arc = (SELECT COUNT(*) FROM {$prefix}archives WHERE typeid = :typeid AND is_del = 0), update_time = :update_time WHERE id = :typeid")
        ->execute([
            'typeid' => $newsTypeId,
            'update_time' => $now,
        ]);

    $pdo->prepare("UPDATE {$prefix}arctype SET total_arc = (SELECT COUNT(*) FROM {$prefix}archives WHERE typeid = :typeid AND is_del = 0), update_time = :update_time WHERE id = :typeid")
        ->execute([
            'typeid' => $downloadTypeId,
            'update_time' => $now,
        ]);

    $pdo->prepare("UPDATE {$prefix}arctype SET total_arc = (SELECT COUNT(*) FROM {$prefix}archives WHERE typeid = :typeid AND is_del = 0), update_time = :update_time WHERE id = :typeid")
        ->execute([
            'typeid' => $videoTypeId,
            'update_time' => $now,
        ]);

    $pdo->exec("TRUNCATE TABLE {$prefix}sql_cache_table");

    $pdo->commit();

    echo "Synced EyouCMS news, downloads, message, and video content.\n";
} catch (Throwable $exception) {
    $pdo->rollBack();
    fwrite(STDERR, $exception->getMessage() . "\n");
    exit(1);
}
