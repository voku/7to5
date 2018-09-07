<?php

use Import;

class Test
{
  // (CRLF|([ZWNJ-ZWJ]|T+|L*(LV?V+|LV|LVT)T*|L+|[^Control])[Extend]*|[Control])
  // This regular expression is a work around for http://bugs.exim.org/1279
  const GRAPHEME_CLUSTER_RX = "(?:\r\n|(?:[ -~\x{200C}\x{200D}]|[ᆨ-ᇹ]+|[ᄀ-ᅟ]*(?:[가개갸걔거게겨계고과괘괴교구궈궤귀규그긔기까깨꺄꺠꺼께껴꼐꼬꽈꽤꾀꾜꾸꿔꿰뀌뀨끄끠끼나내냐냬너네녀녜노놔놰뇌뇨누눠눼뉘뉴느늬니다대댜댸더데뎌뎨도돠돼되됴두둬뒈뒤듀드듸디따때땨떄떠떼뗘뗴또똬뙈뙤뚀뚜뚸뛔뛰뜌뜨띄띠라래랴럐러레려례로롸뢔뢰료루뤄뤠뤼류르릐리마매먀먜머메며몌모뫄뫠뫼묘무뭐뭬뮈뮤므믜미바배뱌뱨버베벼볘보봐봬뵈뵤부붜붸뷔뷰브븨비빠빼뺘뺴뻐뻬뼈뼤뽀뽜뽸뾔뾰뿌뿨쀄쀠쀼쁘쁴삐사새샤섀서세셔셰소솨쇄쇠쇼수숴쉐쉬슈스싀시싸쌔쌰썌써쎄쎠쎼쏘쏴쐐쐬쑈쑤쒀쒜쒸쓔쓰씌씨아애야얘어에여예오와왜외요우워웨위유으의이자재쟈쟤저제져졔조좌좨죄죠주줘줴쥐쥬즈즤지짜째쨔쨰쩌쩨쪄쪠쪼쫘쫴쬐쬬쭈쭤쮀쮜쮸쯔쯰찌차채챠챼처체쳐쳬초촤쵀최쵸추춰췌취츄츠츼치카캐캬컈커케켜켸코콰쾌쾨쿄쿠쿼퀘퀴큐크킈키타태탸턔터테텨톄토톼퇘퇴툐투퉈퉤튀튜트틔티파패퍄퍠퍼페펴폐포퐈퐤푀표푸풔풰퓌퓨프픠피하해햐햬허헤혀혜호화홰회효후훠훼휘휴흐희히]?[ᅠ-ᆢ]+|[가-힣])[ᆨ-ᇹ]*|[ᄀ-ᅟ]+|[^\p{Cc}\p{Cf}\p{Zl}\p{Zp}])[\p{Mn}\p{Me}\x{09BE}\x{09D7}\x{0B3E}\x{0B57}\x{0BBE}\x{0BD7}\x{0CC2}\x{0CD5}\x{0CD6}\x{0D3E}\x{0D57}\x{0DCF}\x{0DDF}\x{200C}\x{200D}\x{1D165}\x{1D16E}-\x{1D172}]*|[\p{Cc}\p{Cf}\p{Zl}\p{Zp}])";

  private static $BOM = [
        "\xef\xbb\xbf"     => 3, // UTF-8 BOM
        'ï»¿'              => 6, // UTF-8 BOM as "WINDOWS-1252" (one char has [maybe] more then one byte ...)
        "\x00\x00\xfe\xff" => 4, // UTF-32 (BE) BOM
        '  þÿ'             => 6, // UTF-32 (BE) BOM as "WINDOWS-1252"
        "\xff\xfe\x00\x00" => 4, // UTF-32 (LE) BOM
        'ÿþ  '             => 6, // UTF-32 (LE) BOM as "WINDOWS-1252"
        "\xfe\xff"         => 2, // UTF-16 (BE) BOM
        'þÿ'               => 4, // UTF-16 (BE) BOM as "WINDOWS-1252"
        "\xff\xfe"         => 2, // UTF-16 (LE) BOM
        'ÿþ'               => 4, // UTF-16 (LE) BOM as "WINDOWS-1252"
    ];

    public function test()
    {
        $class = new class() {
            public function method(string $parameter = '', int $index = 0) : string {

                if (
                    ($index === 0 && $parameter === '1')
                    ||
                    $parameter === ''
                ) {
                  return 'error';
                }

                return $parameter ?? 'no parameter set';
            }
        };
        
        $class->method();

        $anotherClass = new class() {
            public function anotherMethod(int $integer) : int {
                return $integer <=> 3;
            }
        };
    }
            
}
