<?php

namespace Buzzylab\Aip\Models;
use Buzzylab\Aip\Model;

class Standard extends Model
{
    /**
     * Loads initialize values
     *
     * @ignore
     */         
    public function __construct(){}
 
    /**
     * This method will standardize Arabic text to follow writing standards 
     * (just like magazine rules)
     *          
     * @param string $text Arabic text you would like to standardize
     *                    
     * @return String Standardized version of input Arabic text
     * @author Khaled Al-Sham'aa <khaled@ar-php.org>
     */
    public function standard($text)
    {
        $patterns     = [];
        $replacements = [];
        
        array_push($patterns, '/\r\n/u', '/([^\@])\n([^\@])/u', '/\r/u');
        array_push($replacements, "\n@@@\n", "\\1\n&&&\n\\2", "\n###\n");
        
        /**
         * النقطة، الفاصلة، الفاصلة المنقوطة،
         * النقطتان، علامتي الاستفهام والتعجب،
         * النقاط الثلاث المتتالية
         * يترك فراغ واحد بعدها جميعا
         * دون أي فراغ قبلها
         */
        array_push($patterns, '/\s*([\.\،\؛\:\!\؟])\s*/u');
        array_push($replacements, '\\1 ');

        /**
         * النقاط المتتالية عددها 3 فقط
         * (ليست نقطتان وليست أربع أو أكثر)
         */
        array_push($patterns, '/(\. ){2,}/u');
        array_push($replacements, '...');

        /**
         * الأقواس ( ) [ ] { } يترك قبلها وبعدها فراغ
         * وحيد، فيما لا يوجد بينها وبين ما بداخلها
         * أي فراغ
         */
        array_push($patterns, '/\s*([\(\{\[])\s*/u');
        array_push($replacements, ' \\1');

        array_push($patterns, '/\s*([\)\}\]])\s*/u');
        array_push($replacements, '\\1 ');

        /**
         * علامات الاقتباس "..."
         * يترك قبلها وبعدها فراغ
         * وحيد، فيما لا يوجد بينها
         * وبين ما بداخلها أي فراغ
         */
        array_push($patterns, '/\s*\"\s*(.+)((?<!\s)\"|\s+\")\s*/u');
        array_push($replacements, ' "\\1" ');

        /**
         * علامات الإعتراض -...-
         * يترك قبلها وبعدها فراغ
         * وحيد، فيما لا يوجد بينها
         * وبين ما بداخلها أي فراغ
         */
        array_push($patterns, '/\s*\-\s*(.+)((?<!\s)\-|\s+\-)\s*/u');
        array_push($replacements, ' -\\1- ');

        /**
         * لا يترك فراغ بين حرف العطف الواو وبين
         * الكلمة التي تليه
         * إلا إن كانت تبدأ بحرف الواو
         */
        array_push($patterns, '/\sو\s+([^و])/u');
        array_push($replacements, ' و\\1');

        /**
         * الواحدات الإنجليزية توضع
         * على يمين الرقم مع ترك فراغ
         */
        array_push($patterns, '/\s+(\w+)\s*(\d+)\s+/');
        array_push($replacements, ' <span dir="ltr">\\2 \\1</span> ');

        array_push($patterns, '/\s+(\d+)\s*(\w+)\s+/');
        array_push($replacements, ' <span dir="ltr">\\1 \\2</span> ');

        /**
         * النسبة المؤية دائما إلى يسار الرقم
         * وبدون أي فراغ يفصل بينهما 40% مثلا
         */
        array_push($patterns, '/\s+(\d+)\s*\%\s+/u');
        array_push($replacements, ' %\\1 ');
        
        array_push($patterns, '/\n?@@@\n?/u', '/\n?&&&\n?/u', '/\n?###\n?/u');
        array_push($replacements, "\r\n", "\n", "\r");

        $text = preg_replace($patterns, $replacements, $text);

        return $text;
    }
}