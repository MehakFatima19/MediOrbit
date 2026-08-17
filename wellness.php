<?php
/**
 * MediOrbit - Wellness Guide (View 2)
 * 
 * Replicates the clean, clinical, and premium aesthetics of the
 * MediCompass design system.
 */

require_once __DIR__ . '/config/db.php';

$blogs = [];

try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM wellness_blogs ORDER BY id ASC");
    $blogs = $stmt->fetchAll();
} catch (Exception $e) {
    // Graceful fallback for initial loading before database setup
    $blogs = [
        [
            'id' => 1,
            'category' => 'GASTROENTEROLOGY',
            'read_time' => '4 min read',
            'title_en' => 'Understanding and Preventing Organ Strain',
            'title_ur' => 'اعضاء پر دباؤ (Organ Strain) کی وجوہات اور بچاؤ',
            
            // --- Description والا حصہ ---
            'excerpt_en' => 'How overeating and constant grazing exhaust internal organs like the liver and kidneys, and ways to restore their efficiency.',
            'excerpt_ur' => 'ہر وقت کھاتے رہنے اور زیادہ کھانے سے جگر، معدہ اور گردوں جیسے اعضاء کیسے تھک جاتے ہیں اور ان کی کارکردگی کو بحال کرنے کے طریقے کیا ہیں۔',
            'detailed_desc_en' => 'When we eat food, our internal organs—including the liver, stomach, pancreas, and kidneys—have to work incredibly hard to digest that food and clear out toxins. When the body is continuously fed without any rest, the cells of these organs become exhausted, and their efficiency declines. This constant pressure and fatigue is known as organ strain, which causes organs to weaken prematurely.',
            'detailed_desc_ur' => 'جب ہم کھانا کھاتے ہیں تو ہمارے اندرونی اعضاء بشمول جگر، معدہ، لبلبہ اور گردوں کو اس کھانے کو ہضم کرنے اور زہریلے مادوں کو صاف کرنے کے لیے ناقابل یقین حد تک سخت محنت کرنی پڑتی ہے۔ جب جسم کو بغیر کسی آرام کے مسلسل کھانا کھلایا جاتا ہے، تو ان اعضاء کے خلیات تھک جاتے ہیں، اور ان کی کارکردگی کم ہو جاتی ہے۔ اس مسلسل دباؤ اور تھکاوٹ کو اعضاء کا دباؤ (Organ Strain) کہا جاتا ہے، جو اعضاء کو وقت سے پہلے کمزور کر دیتا ہے۔',
            
            // --- Reason والا حصہ ---
            'reasons_en' => '1. Overeating and constant grazing (eating something all the time). * 2. Lack of nutritional awareness, leading people to assume that eating frequently is good for health. * 3. The stomach never gets a chance to empty, keeping the entire digestive system under constant pressure.',
            'reasons_ur' => '1. ضرورت سے زیادہ کھانا اور ہر وقت کچھ نہ کچھ کھاتے رہنا (Constant Grazing)۔ * 2. غذائی شعور کی کمی، جس کی وجہ سے لوگ یہ سمجھتے ہیں کہ بار بار کھانا صحت کے لیے اچھا ہے۔ * 3. معدے کو کبھی خالی ہونے کا موقع نہیں ملتا، جس سے پورا نظامِ ہضم مسلسل دباؤ میں رہتا ہے۔',
            
            // --- Avoid والا حصہ ---
            'avoid_things_en' => '1. Eating without actual, genuine hunger. * 2. Consuming heavy meals, especially right before going to sleep at night. * 3. Packaged foods containing artificial preservatives and chemicals.',
            'avoid_things_ur' => '1. سچی اور حقیقی بھوک کے بغیر کھانا کھانے سے پرہیز کریں۔ * 2. رات کو سونے سے بالکل پہلے بھاری کھانا کھانے سے گریز کریں۔ * 3. مصنوعی کیمیکلز اور پرسکون رکھنے والے مادوں (Preservatives) والے ڈبہ بند کھانوں سے دور رہیں۔',
            
            // --- Control والا حصہ (جو آپ کے ٹیکسٹ کے آخر میں تھا) ---
            'control_things_en' => '1. Portion Control: Always maintain your food portions by leaving a little room for hunger. * 2. Meal Timing: Allow at least a 5-hour gap between meals so your organs can finish their work and rest. * 3. Eat a light and simple diet one day a week to give your internal system a much-needed break.',
            'control_things_ur' => '1. پورشن کنٹرول: کھانے کی مقدار کو ہمیشہ قابو میں رکھیں اور تھوڑی سی بھوک باقی رکھ کر کھائیں۔ * 2. کھانے کا وقفہ: کھانوں کے درمیان کم از کم 5 گھنٹے کا وقفہ دیں تاکہ اعضاء کو کام ختم کرنے اور آرام کا موقع ملے۔ * 3. ہفتے میں ایک دن ہلکی اور سادہ غذا کھائیں تاکہ آپ کے اندرونی نظام کو ضروری آرام مل سکے۔',
            
            'image_url' => 'assets/organ_strain.jpg'
        ],
        [
            'id' => 2,
            'category' => 'ENDOCRINOLOGY',
            'read_time' => '5 min read',
            'title_en' => 'Metabolic Stress',
            'title_ur' => 'میٹابولک اسٹریس (Metabolic Stress)',
            
            // --- Description والا حصہ ---
            'excerpt_en' => 'How overfueling the body disrupts chemical processes, weakens cells, and triggers silent, chronic inflammation.',
            'excerpt_ur' => 'جسم کو ضرورت سے زیادہ ایندھن (کھانا) دینے سے کیمیائی نظام کیسے متاثر ہوتا ہے، خلیات کمزور ہوتے ہیں اور اندرونی سوزش پیدا ہوتی ہے۔',
            'detailed_desc_en' => 'Metabolism is our body\'s internal engine that converts food into energy. When we dump more fuel (food) into the body than it actually needs, it places a severe strain on this system, known as metabolic stress. This stress disrupts the body\'s internal chemical processes, weakens cells, and triggers silent, chronic inflammation within the body.',
            'detailed_desc_ur' => 'میٹابولزم ہمارے جسم کا اندرونی انجن ہے جو کھانے کو توانائی میں تبدیل کرتا ہے۔ جب ہم جسم میں اس کی ضرورت سے زیادہ ایندھن (کھانا) ڈالتے ہیں، تو یہ اس نظام پر شدید دباؤ ڈالتا ہے، جسے میٹابولک اسٹریس کہا جاتا ہے۔ یہ تناؤ جسم کے اندرونی کیمیائی عمل کو درہم برہم کرتا ہے، خلیات کو کمزور کرتا ہے، اور جسم کے اندر خاموش اور دائمی سوزش کو جنم دیتا ہے۔',
            
            // --- Reason والا حصہ ---
            'reasons_en' => '1. Consuming a diet that is high in calories but low in nutrients (such as junk food). * 2. Lack of nutritional awareness leading people to consume calorie-packed but vitamin-deficient items. * 3. Overwhelming the cells, leaving them unable to cope with the excessive energy load.',
            'reasons_ur' => '1. ایسی غذا کا استعمال جس میں کیلوریز زیادہ ہوں لیکن غذائیت کم ہو (جیسے جنک فوڈ)۔ * 2. غذائی شعور کی کمی، جس کی وجہ سے لوگ ایسی چیزیں کھاتے ہیں جو کیلوریز سے بھرپور لیکن ضروری وٹامنز سے خالی ہوتی ہیں۔ * 3. خلیات پر ضرورت سے زیادہ بوجھ بڑھ جانا، جس سے وہ اس اضافی توانائی کو سنبھالنے کے قابل نہیں رہتے۔',
            
            // --- Avoid والا حصہ ---
            'avoid_things_en' => '1. Avoid processed foods, bakery items (biscuits, cakes), and packaged snacks. * 2. Stay completely away from cold drinks, sodas, and artificial energy drinks. * 3. Avoid sitting all day and living a sedentary, inactive lifestyle.',
            'avoid_things_ur' => '1. پروسیس شدہ کھانوں (Processed foods)، بیکری کی اشیاء (بسکٹ، کیک) اور ڈبہ بند اسنیکس سے پرہیز کریں۔ * 2. کولڈ ڈرنکس، سوڈا اور مصنوعی انرجی ڈرنکس سے مکمل طور پر دور رہیں۔ * 3. سارا دن بیٹھے رہنے اور سست یا غیر فعال طرزِ زندگی سے گریز کریں۔',
            
            // --- Control والا حصہ ---
            'control_things_en' => '1. Wholesome Diet: Eat wholesome and natural foods—such as raw vegetables, lentils, and nuts. * 2. Regular Exercise: Exercise for at least 20–30 minutes daily; this activates your cells and significantly reduces metabolic stress. * 3. Quality Sleep: Get adequate sleep at night, as poor sleep quality further escalates bodily stress.',
            'control_things_ur' => '1. خالص غذا: صحت بخش اور قدرتی غذا کھائیں—جیسے کچی سبزیاں، دالیں اور گری دار میوے (Nuts)۔ * 2. باقاعدہ ورزش: روزانہ کم از کم 20 سے 30 منٹ ورزش کریں؛ یہ آپ کے خلیات کو فعال کرتی ہے اور میٹابولک تناؤ کو نمایاں طور پر کم کرتی ہے۔ * 3. بھرپور نیند: رات کو مناسب اور اچھی نیند لیں، کیونکہ نیند کی کمی جسمانی تناؤ کو مزید بڑھاتی ہے۔',
            
            'image_url' => 'assets/Metabolism1.jpg'
        ],
        [
            'id' => 3,
            'category' => 'CARDIOLOGY',
            'read_time' => '4 min read',
            'title_en' => 'Bloating',
            'title_ur' => 'پیٹ کا پھولنا اور گیس (Bloating)',
            
            // --- Description والا حصہ ---
            'excerpt_en' => 'How excess gas and fluid retention cause the stomach to swell like a balloon, leading to constant heaviness and discomfort.',
            'excerpt_ur' => 'پیٹ میں ضرورت سے زیادہ گیس اور پانی بھر جانے سے معدہ غبارے کی طرح کیسے پھول جاتا ہے اور مستقل بھاری پن کا باعث بنتا ہے۔',
            'detailed_desc_en' => 'Bloating happens when the digestive tract becomes filled with excessive gas or retains too much fluid. This causes the stomach to swell up like a balloon and become stiff, leaving a person feeling extremely uncomfortable, restless, and heavy even while simply sitting or standing.',
            'detailed_desc_ur' => 'پیٹ کا پھولنا (Bloating) تب ہوتا ہے جب نظامِ ہضم میں ضرورت سے زیادہ گیس بھر جاتی ہے یا پانی رک جاتا ہے۔ اس کی وجہ سے پیٹ غبارے کی طرح پھول جاتا ہے اور سخت ہو جاتا ہے، جس سے انسان کو بیٹھنے یا کھڑے ہونے میں بھی شدید بے آرامی، بے چینی اور بھاری پن محسوس ہوتا ہے۔',
            
            // --- Reason والا حصہ ---
            'reasons_en' => '1. Eating too quickly and swallowing food without chewing it properly, forcing excess air into the stomach. * 2. Lack of nutritional awareness, leading people to drink ice-cold water or eat sweets immediately after a meal. * 3. Food fermenting and generating gas inside the digestive tract instead of digesting properly.',
            'reasons_ur' => '1. بہت جلدی جلدی کھانا اور چبائے بغیر نگل لینا، جس سے اضافی ہوا معدے میں چلی جاتی ہے۔ * 2. غذائی شعور کی کمی، جس کی وجہ سے لوگ کھانے کے فوراً بعد برف کا ٹھنڈا پانی پیتے ہیں یا میٹھا کھاتے ہیں۔ * 3. کھانے کا صحیح طریقے سے ہضم ہونے کے بجائے معدے میں سڑنا (Ferment ہونا) اور گیس پیدا کرنا۔',
            
            // --- Avoid والا حصہ ---
            'avoid_things_en' => '1. Avoid carbonated beverages (sodas, cold drinks) and chewing gum. * 2. Avoid highly salty, spicy, and heavily seasoned foods. * 3. Avoid looking at your phone or talking while eating, as this causes you to swallow excess air.',
            'avoid_things_ur' => '1. کاربونیٹڈ مشروبات (سوڈا، کولڈ ڈرنکس) اور چیونگم سے پرہیز کریں۔ * 2. بہت زیادہ نمکین، مسالے دار اور تیز مرچوں والے کھانوں سے گریز کریں۔ * 3. کھانا کھاتے وقت فون دیکھنے یا باتیں کرنے سے پرہیز کریں، کیونکہ اس سے آپ اضافی ہوا نگل لیتے ہیں۔',
            
            // --- Control والا حصہ ---
            'control_things_en' => '1. Mindful Chewing: Chew every single mouthful of food thoroughly, aiming for at least 32 times, and eat slowly. * 2. Water Timing: Instead of drinking water immediately after eating, wait for at least 30 minutes. * 3. Natural Remedies: Drink mint water or fennel (saunf) tea, which helps expel gas instantly.',
            'control_things_ur' => '1. اچھی طرح چبانا: کھانے کے ہر نوالے کو اچھی طرح چبائیں (کم از کم 32 بار کا ہدف رکھیں) اور آہستہ کھائیں۔ * 2. پانی کا وقت: کھانے کے فوراً بعد پانی پینے کے بجائے کم از کم 30 منٹ انتظار کریں۔ * 3. قدرتی علاج: پودینے کا پانی یا سونف کی چائے پییں، جو گیس کو فوری خارج کرنے میں مدد کرتی ہے۔',
            
            'image_url' => 'database/images/bloating.jpg'
        
        ],
        [
           'id' => 4,
            'category' => 'METABOLISM',
            'read_time' => '5 min read',
            'title_en' => 'Abdominal Discomfort',
            'title_ur' => 'پیٹ کی بے آرامی اور درد (Abdominal Discomfort)',
            
            // --- Description والا حصہ ---
            'excerpt_en' => 'How a failure to break down food properly leads to rising stomach acid, persistent restlessness, and cramping.',
            'excerpt_ur' => 'کھانے کے صحیح طریقے سے ہضم نہ ہونے کی وجہ سے تیزابیت کا بڑھنا، مسلسل بے چینی اور مروڑ پیدا ہونے کی وجوہات۔',
            'detailed_desc_en' => 'Abdominal discomfort refers to the persistent restlessness, burning sensation, or mild cramping in the mid-stomach area that keeps a person constantly uneasy. It is a clear sign that the stomach is failing to break down food properly, causing stomach acid levels to rise higher than normal.',
            'detailed_desc_ur' => 'پیٹ کی بے آرامی (Abdominal Discomfort) سے مراد معدے کے درمیانی حصے میں مسلسل بے چینی، جلن یا ہلکے مروڑ ہیں جو انسان کو ہر وقت بے سکون رکھتے ہیں۔ یہ اس بات کی واضح علامت ہے کہ معدہ کھانے کو صحیح طریقے سے ہضم کرنے میں ناکام ہو رہا ہے، جس کی وجہ سے معدے میں تیزابیت کی سطح معمول سے زیادہ بڑھ جاتی ہے۔',
            
            // --- Reason والا حصہ ---
            'reasons_en' => '1. Overeating causing the stomach to overfill, forcing excess acid to travel upward toward the throat. * 2. Lack of nutritional awareness leading people to eat fiberless foods (fast food, refined flour) that get stuck in the intestines. * 3. Digestion failures generating painful gas, cramps, and persistent intestinal pressure.',
            'reasons_ur' => '1. زیادہ کھانے سے معدے کا حد سے زیادہ بھر جانا، جس کی وجہ سے اضافی تیزابیت اوپر حلق کی طرف آنے لگتی ہے۔ * 2. غذائی شعور کی کمی، جس کی وجہ سے لوگ بغیر فائبر والی غذائیں (فاسٹ فوڈ، میدہ) کھاتے ہیں جو آنتوں میں پھنس جاتی ہیں۔ * 3. ہاضمے کی خرابی جس سے پیٹ میں دردناک گیس، مروڑ اور آنتوں پر مستقل دباؤ پیدا ہوتا ہے۔',
            
            // --- Avoid والا حصہ ---
            'avoid_things_en' => '1. Avoid eating out, especially fried items sold in open-air markets. * 2. Avoid the habit of eating right before going to bed. * 3. Limit your intake of tea and coffee, as excessive amounts irritate the stomach lining.',
            'avoid_things_ur' => '1. باہر کے کھانوں، خاص طور پر کھلی جگہوں پر بکنے والی تلی ہوئی چیزوں سے پرہیز کریں۔ * 2. رات کو سونے سے بالکل پہلے کھانا کھانے کی عادت سے گریز کریں۔ * 3. چائے اور کافی کا استعمال محدود کریں، کیونکہ ان کی زیادہ مقدار معدے کی اندرونی جھلی کو متاثر کرتی ہے۔',
            
            // --- Control والا حصہ ---
            'control_things_en' => '1. High-Fiber Intake: Incorporate plenty of fiber into your diet, such as cucumbers, carrots, and apples. * 2. Use Probiotics: Include yogurt in your meals; it is packed with healthy bacteria (probiotics) that fix digestion. * 3. Hydration Strategy: Drink 8–10 glasses of clean water daily, but avoid drinking it during your meals.',
            'control_things_ur' => '1. فائبر کا استعمال: اپنی غذا میں وافر مقدار میں فائبر شامل کریں، جیسے کھیرا، گاجر اور سیب۔ * 2. پروبائیوٹکس کا استعمال: اپنے کھانوں میں دہی شامل کریں؛ یہ صحت مند بیکٹیریا (Probiotics) سے بھرپور ہوتی ہے جو ہاضمے کو درست کرتا ہے۔ * 3. پانی کا صحیح طریقہ: روزانہ 8 سے 10 گلاس صاف پانی پییں، لیکن کھانا کھانے کے دوران پانی پینے سے گریز کریں۔',
            
            'image_url' => 'database/images/abdominal_discomfort.jpg'
        ],
        [
            'id' => 5,
            'category' => 'VASCULAR',
            'read_time' => '5 min read',
            'title_en' => 'Diabetes',
            'title_ur' => 'ذیابیطس / شوگر (Diabetes)',
            
            // --- Description والا حصہ ---
            'excerpt_en' => 'How insulin resistance or low insulin production prevents food from converting into energy, leaving sugar to circulate in the bloodstream.',
            'excerpt_ur' => 'انسولین کی کمی یا خلیات کی مزاحمت کے باعث کھانا توانائی میں تبدیل کیوں نہیں ہوتا اور خون میں شوگر کا لیول کیسے بڑھتا ہے۔',
            'detailed_desc_en' => 'Diabetes occurs when an organ called the pancreas stops producing enough insulin, or when the body\'s cells become resistant to the insulin being produced. When insulin fails to do its job, the sugar generated from the food we eat cannot be converted into energy. Instead, it continuously circulates in the bloodstream, leaving the body weak from the inside.',
            'detailed_desc_ur' => 'ذیابیطس (شوگر) تب ہوتی ہے جب لبلبہ نامی عضو کافی انسولین بنانا بند کر دیتا ہے، یا جب جسم کے خلیات پیدا ہونے والی انسولین کا اثر قبول نہیں کرتے۔ جب انسولین اپنا کام کرنے میں ناکام ہو جاتی ہے، تو ہمارے کھائے گئے کھانے سے بننے والی شوگر توانائی میں تبدیل نہیں ہو پاتی۔ اس کے بجائے، یہ مسلسل خون میں گردش کرتی رہتی ہے، جس سے جسم اندر سے کمزور ہو جاتا ہے۔',
            
            // --- Reason والا حصہ ---
            'reasons_en' => '1. Excessive and unchecked consumption of refined carbohydrates and sugar. * 2. Lack of nutritional awareness leading to the daily intake of massive amounts of white rice, refined flour (maida), and flatbreads. * 3. Continuous overworking of the pancreas leading to the eventual breakdown of the body\'s insulin system.',
            'reasons_ur' => '1. ریفائنڈ کاربوہائیڈریٹس (صاف شدہ نشاستہ) اور چینی کا بے تحاشہ اور بے دریغ استعمال۔ * 2. غذائی شعور کی کمی، جس کی وجہ سے روزانہ بڑی مقدار میں سفید چاول، میدہ، روٹی اور میٹھی چیزیں کھائی جاتی ہیں۔ * 3. لبلبے پر مستقل بوجھ بڑھنا جس کے نتیجے میں بالاآخر جسم کا انسولین کا نظام ناکام ہو جاتا ہے۔',
            
            // --- Avoid والا حصہ ---
            'avoid_things_en' => '1. Avoid white sugar, sweets, bakery products, and packaged juices. * 2. Discontinue the use of white rice and refined white bread. * 3. Avoid laziness and the habit of sitting for extended periods.',
            'avoid_things_ur' => '1. سفید چینی، مٹھائیوں، بیکری کی مصنوعات اور ڈبے والے جوسز سے پرہیز کریں۔ * 2. سفید چاول اور سفید ڈبل روٹی (Refined white bread) کا استعمال بند کریں۔ * 3. سستی، کاہلی اور طویل عرصے تک بیٹھے رہنے کی عادت سے گریز کریں۔',
            
            // --- Control والا حصہ ---
            'control_things_en' => '1. Complex Carbohydrates: Introduce complex carbohydrates into your diet, such as whole wheat flour, barley, and oats. * 2. Daily Walk: Engage in at least 30 to 45 minutes of brisk walking every day to help burn off excess blood sugar. * 3. Pre-Meal Salads: Eat raw vegetables and salads before your main meal to prevent sudden spikes in blood sugar levels.',
            'control_things_ur' => '1. کمپلیکس کاربوہائیڈریٹس: اپنی غذا میں پیچیدہ نشاستہ (Complex carbohydrates) شامل کریں، جیسے چکی کا آٹا، جو اور جئی (Oats)۔ * 2. روزانہ چہل قدمی: خون میں موجود اضافی شوگر کو جلانے کے لیے روزانہ کم از کم 30 سے 45 منٹ تیز قدموں سے واک کریں۔ * 3. کھانے سے پہلے سلاد: اپنے اصل کھانے سے پہلے کچی سبزیاں اور سلاد کھائیں تاکہ خون میں شوگر کی سطح اچانک نہ بڑھے۔',
            
            'image_url' => 'database/images/diabetes.jpg'
        ],
        [
            'id' => 6,
            'category' => 'NUTRITION',
            'read_time' => '5 min read',
            'title_en' => 'Hypertension (High Blood Pressure)',
            'title_ur' => 'ہائی بلڈ پریشر (Hypertension)',
            
            // --- Description والا حصہ ---
            'excerpt_en' => 'How consistently high blood pressure hardens arterial walls and forces the heart to overwork, endangering the brain and heart.',
            'excerpt_ur' => 'خون کا دباؤ مسلسل ہائی رہنے سے شریانیں کیسے سخت ہو جاتی ہیں اور دل پر دباؤ بڑھنے سے دماغ اور دل کو کیا خطرات لاحق ہوتے ہیں۔',
            'detailed_desc_en' => 'Blood pressure is the force with which blood circulates through our blood vessels. When this pressure consistently stays above normal limits, it is called hypertension. It hardens the arterial walls and forces the heart to exert massive effort to pump blood, which is highly dangerous for both the brain and the heart.',
            'detailed_desc_ur' => 'بلڈ پریشر وہ طاقت ہے جس کے ذریعے خون ہماری رگوں میں گردش کرتا ہے۔ جب یہ دباؤ مسلسل معمول کی حد سے اوپر رہے تو اسے ہائی بلڈ پریشر (Hypertension) کہا جاتا ہے۔ یہ شریانوں کی دیواروں کو سخت کر دیتا ہے اور دل کو خون پمپ کرنے کے لیے بے پناہ طاقت لگانے پر مجبور کرتا ہے، جو دماغ اور دل دونوں کے لیے انتہائی خطرناک ہے۔',
            
            // --- Reason والا حصہ ---
            'reasons_en' => '1. Overeating and increased body fat narrowing the pathways inside the blood vessels. * 2. High amounts of sodium (salt) hidden in packaged foods and fast food serving as a leading trigger. * 3. Chronic vascular tension forcing the heart to exert excessive physical effort.',
            'reasons_ur' => '1. زیادہ کھانے اور جسم کی چربی بڑھنے سے خون کی رگوں کے اندرونی راستے کا تنگ ہو جانا۔ * 2. ڈبہ بند کھانوں اور فاسٹ فوڈ میں چھپی ہوئی سوڈیم (نمک) کی بھاری مقدار جو بلڈ پریشر بڑھانے کی بڑی وجہ ہے۔ * 3. رگوں میں مستقل تناؤ جس کی وجہ سے دل کو خون پمپ کرنے کے لیے حد سے زیادہ محنت کرنی پڑتی ہے۔',
            
            // --- Avoid والا حصہ ---
            'avoid_things_en' => '1. Avoid sprinkling raw salt on top of your cooked meals entirely. * 2. Avoid pickles, papadums, chips, and canned foods that contain exceptionally high sodium levels. * 3. Avoid smoking and excessive fits of anger.',
            'avoid_things_ur' => '1. پکے ہوئے کھانے کے اوپر سے کچا نمک چھڑکنے سے مکمل پرہیز کریں۔ * 2. اچار، پاپڑ، چپس اور ڈبہ بند کھانوں سے دور رہیں جن میں سوڈیم کی مقدار بہت زیادہ ہوتی ہے۔ * 3. سگریٹ نوشی اور شدید غصہ کرنے کی عادت سے گریز کریں۔',
            
            // --- Control والا حصہ ---
            'control_things_en' => '1. Reduce Sodium: Drastically reduce the amount of salt in your cooking and substitute it with lemon juice or flavorful herbs. * 2. Potassium-Rich Diet: Eat potassium-rich foods like bananas, dates, and spinach, which naturally counteract the harmful effects of sodium. * 3. Stress Management: Practice deep breathing and yoga to keep your nervous system calm.',
            'control_things_ur' => '1. نمک میں کمی: کھانے میں نمک کی مقدار کو واضح طور پر کم کریں اور اس کی جگہ لیموں کا رس یا خوشبودار جڑی بوٹیاں استعمال کریں۔ * 2. پوٹاشیم سے بھرپور غذا: پوٹاشیم سے بھرپور چیزیں کھائیں جیسے کیلے، کھجور اور پالک، جو قدرتی طور پر سوڈیم کے نقصانات کو ختم کرتی ہیں۔ * 3. اعصاب کو پرسکون رکھنا: اپنے اعصابی نظام کو پرسکون رکھنے کے لیے گہرے سانس لینے کی مشق (Deep breathing) اور یوگا کریں۔',
            
            'image_url' => 'database/images/hypertension.jpg'
        ]
    ];
}

// Ensure includes the correct navbar
include_once __DIR__ . '/includes/navbar.php';
?>

<!-- Set body background for View 2 to green-grey clinical tint -->
<div class="wellness-body flex-grow-1 py-5">
    <div class="container container-desktop">
        
        <!-- 1. Header Section -->
        <div class="row align-items-center mb-5">
            <div class="col-md-9 text-start">
                <h1 class="clinical-heading mb-2" style="font-size: 38px;">Wellness Guide</h1>
                <p class="clinical-subtext mb-0" style="max-width: 680px;">
                    Expert insights and medically-vetted strategies to help you manage metabolic health, improve vitality, and navigate your journey toward clinical excellence.
                </p>
            </div>
            <div class="col-md-3 text-md-end text-start mt-3 mt-md-0">
                <button class="btn btn-all-topics">
                    <i class="fa-solid fa-notes-medical me-1"></i> All Topics
                </button>
            </div>
        </div>

        <!-- 2. Responsive 4x3 Cards Grid -->
        <div class="row g-4" id="blogsContainerGrid">
            <?php foreach ($blogs as $index => $blog): ?>
                <?php $hiddenClass = ($index >= 6) ? 'd-none blog-hidden-card' : ''; ?>
                <div class="col-lg-4 col-md-6 col-sm-12 fade-in-up <?php echo $hiddenClass; ?>" style="animation-delay: <?php echo ($index % 6) * 100; ?>ms;">
                    <!-- Raw blog payload in card attribute for instant JS reading -->
                    <div class="blog-card" 
                         data-id="<?php echo $blog['id']; ?>"
                         data-blog-raw='<?php echo htmlspecialchars(json_encode($blog), ENT_QUOTES, 'UTF-8'); ?>'>
                        
                        <div class="blog-img-wrapper">
                            <img src="<?php echo $blog['image_url']; ?>" alt="<?php echo htmlspecialchars($blog['title_en']); ?>" class="blog-img" onerror="this.src='https://picsum.photos/seed/med<?php echo $blog['id']; ?>/400/250'">
                        </div>
                        
                        <div class="blog-body">
                            <div class="blog-meta">
                                <span class="blog-category"><?php echo htmlspecialchars($blog['category']); ?></span>
                                <span class="blog-read-time"><?php echo htmlspecialchars($blog['read_time']); ?></span>
                            </div>
                            <h5 class="blog-title"><?php echo htmlspecialchars($blog['title_en']); ?></h5>
                            <p class="blog-excerpt"><?php echo htmlspecialchars($blog['excerpt_en']); ?></p>
                            <a href="#" class="blog-link">
                                Read More <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 3. Dynamic AJAX Load More Button -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <button class="btn btn-load-more d-inline-flex align-items-center" id="loadMoreBlogsBtn">
                    <i class="fa-solid fa-rotate me-2"></i> Load More Articles
                </button>
            </div>
        </div>

    </div>
</div>

<!-- 4. Immersive Frosted-Glass Lightbox Modal Container -->
<div class="modal fade" id="blogDetailModal" tabindex="-1" aria-labelledby="blogDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-custom bg-white">
            
            <!-- Modal Header -->
            <div class="modal-header modal-header-custom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-translate d-flex align-items-center me-3" id="modalTranslateBtn" style="border-color: var(--primary-color); color: var(--primary-color);">
                        <i class="fa-solid fa-language me-1"></i> <span id="modalTranslateBtnText">اردو میں ترجمہ کریں</span>
                    </button>
                    <div id="modalBlogMeta" class="small"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Modal Content Frame (reactive translation changes) -->
            <div id="modalContentZone" class="modal-body modal-body-custom position-relative">
                <h3 id="modalBlogTitle" class="modal-detailed-title mb-3"></h3>
                <img id="modalBlogImg" src="" alt="Blog Cover" class="modal-blog-img shadow-sm">
                
                <!-- Dynamic body text loaded via JS -->
                <div id="modalBlogBody"></div>
                
                <!-- Floating Contextual Chatbot Panel -->
                <div id="blogChatPanel" class="position-absolute shadow-lg" style="display: none; bottom: 80px; right: 20px; width: 350px; background: white; border-radius: 12px; z-index: 1050; border: 1px solid #d1c9bd;">
                    <div class="p-3 text-white" style="background-color: var(--primary-color); border-radius: 12px 12px 0 0;">
                        <h6 class="m-0 fw-bold"><i class="fa-solid fa-robot me-2"></i> Article AI Assistant</h6>
                    </div>
                    <div id="blogChatBox" style="height: 300px; overflow-y: auto; padding: 15px; background: #f9fbf9;">
                        <div class="text-center text-muted small mt-2">Ask a question about this specific article!</div>
                    </div>
                    <form id="blogChatForm" class="d-flex p-2 border-top bg-white" style="border-radius: 0 0 12px 12px;">
                        <input type="text" id="blogChatInput" class="form-control me-2" placeholder="Ask something..." required style="font-size: 14px;">
                        <button type="submit" class="btn" style="background-color: var(--primary-color); color: white;"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer modal-footer-custom d-flex justify-content-between">
                <button id="blogChatToggleBtn" type="button" class="btn btn-primary d-flex align-items-center px-4" style="background-color: var(--primary-color); border: none; border-radius: 6px;">
                    <i class="fa-solid fa-robot me-2"></i> Ask AI Chatbot
                </button>
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="background-color: #6c757d; border: none; border-radius: 6px;">
                    Close Article
                </button>
            </div>
            
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
let currentBlogContext = "";

// Intercept clicks on blog cards to capture their context
document.addEventListener('click', function(e) {
    const card = e.target.closest('.blog-card');
    if (card) {
        const raw = JSON.parse(card.getAttribute('data-blog-raw'));
        currentBlogContext = `Title: ${raw.title_en}\nContent: ${raw.detailed_desc_en}\nCauses: ${raw.reasons_en}\nPrevention: ${raw.avoid_things_en}`;
        document.getElementById('blogChatBox').innerHTML = '<div class="text-center text-muted small mt-2">Ask a question about this specific article!</div>';
        document.getElementById('blogChatPanel').style.display = 'none';
    }
});

document.getElementById('blogChatToggleBtn').addEventListener('click', function() {
    const panel = document.getElementById('blogChatPanel');
    panel.style.display = (panel.style.display === 'none' || panel.style.display === '') ? 'block' : 'none';
});

document.getElementById('blogChatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const input = document.getElementById('blogChatInput');
    const msg = input.value.trim();
    if(!msg) return;
    
    appendBlogMessage('You', msg, true);
    input.value = '';
    
    const chatBox = document.getElementById('blogChatBox');
    const loadingId = 'loading-blog-' + Date.now();
    chatBox.innerHTML += `
        <div class="d-flex mb-3" id="${loadingId}">
            <div class="me-3"><i class="fa-solid fa-robot fa-2x" style="color: var(--primary-color);"></i></div>
            <div class="p-2 px-3 text-muted" style="background-color: #e8f5e9; border-radius: 12px 12px 12px 0;">
                <i class="fa-solid fa-ellipsis fa-fade"></i> Reading article...
            </div>
        </div>
    `;
    chatBox.scrollTop = chatBox.scrollHeight;

    const formData = new FormData();
    // Prepend the blog context to the message so the AI knows what we are talking about
    const enrichedMessage = `[CONTEXT: The user is currently reading the following article:\n${currentBlogContext}\n]\n\nUser Question: ${msg}`;
    formData.append('message', enrichedMessage);
    formData.append('persona', 'blog_bot');

    fetch('api/chat.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
        document.getElementById(loadingId).remove();
        if(data.status === 'success') {
            appendBlogMessage('Bot', data.reply, false);
        } else {
            appendBlogMessage('System', 'Error connecting to AI.', false);
        }
    }).catch(err => {
        document.getElementById(loadingId).remove();
        appendBlogMessage('System', 'Connection failed.', false);
    });
});

function appendBlogMessage(sender, text, isUser) {
    const chatBox = document.getElementById('blogChatBox');
    const bg = isUser ? '#1b3322' : '#e8f5e9';
    const color = isUser ? '#fff' : '#1b3322';
    const radius = isUser ? '12px 12px 0 12px' : '12px 12px 12px 0';
    const align = isUser ? 'justify-content-end' : '';
    const avatarStr = isUser ? '' : `<div class="me-3"><i class="fa-solid fa-robot fa-2x" style="color: var(--primary-color);"></i></div>`;
    
    const htmlContent = isUser ? text : marked.parse(text);

    const html = `
        <div class="d-flex mb-3 ${align}">
            ${avatarStr}
            <div class="p-2 px-3" style="background-color: ${bg}; color: ${color}; border-radius: ${radius}; max-width: 80%; font-size: 14px;">
                ${htmlContent}
            </div>
        </div>
    `;
    chatBox.innerHTML += html;
    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>
