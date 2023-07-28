<?php
/**
 * Created by IntelliJ IDEA.
 *
 * @author Timothy Wilson <tim.wilson@aceviral.com>
 * Date: 13/02/2019
 * Time: 19:00
 */

namespace Altrozero\PostcodeUK\Test;

require 'vendor/autoload.php';

use Altrozero\PostcodeUK\Postcode;
use PHPUnit\Framework\TestCase;

class PostcodeTest extends TestCase
{
    public static function inputPostcodesValidator()
    {
        return [
            ['NE29 0EG', true],
            ['CT13 9FD', true],
            ['B37 7UA', true],
            ['W1H 2LQ', true],
            ['W2 1JB', true],
            ['NE290EG', true],
            ['CT139FD', true],
            ['B377UA', true],
            ['W1H2LQ', true],
            ['BANGARANG', false],
            ['C1 11', false],
            ['BHK37 7UA', false],
            ['W1H 22LQ', false],
            ['W122LQFD', false],
            ['W1 H2H', false],
            ['', false],
            [' ', false]
        ];
    }

    public static function inputPostcodesParts()
    {
        return [
            ['NE29 0EG', true, 'NE29', '0EG', 'NE', '29', '0', 'EG'],
            ['B37 7UA', true, 'B37', '7UA', 'B', '37', '7', 'UA'],
            ['W1H 2LQ', true, 'W1H', '2LQ', 'W', '1H', '2', 'LQ'],
            ['W2 1JB', true, 'W2', '1JB', 'W', '2', '1', 'JB'],
            ['NE290EG', false, 'NE290', '90EG', 'N', '1', 'NE', '9'],
            ['CT139FD', false, 'CT139FD', 'CT139FD', 'CT139FD', 'CT139FD', 'CT139FD', 'CT139FD'],
        ];
    }

    public static function inputFindInString()
    {
        return [
            ['13, Fake Street, Fake Vill, Fake City, Fake Country, NE29 0EG', 'NE290EG'],
            ['13, Fake Street, Fake Vill, Fake City, Fake Country, NE20EG', 'NE20EG'],
            ['13, Fake Street, Fake Vill, Fake City, Fake Country, ne290EG', 'NE290EG'],
            ['13, Fake Street, Fake Vill, Fake City, Fake Country, ne290eg', 'NE290EG'],
            ['13, Fake Street, Fake Vill, Fake City, Fake Country', ''],
            ['Fake House Name Fake Street NE29 0EG', 'NE290EG'],
            ['Fake House Name Fake Street NE29 0EG United Kingdom', 'NE290EG'],
            ['Fake House Name Fake Street NE29 0EG, United Kingdom', 'NE290EG'],
            ['Fake House Name Fake Street NE29 0EG United Kingdom CT13 9FD', 'NE290EG'],
            ['Fake House', ''],
            ['123', ''],
            ['Flat1/a 12 Fake Street, Fake Vill', ''],
            ['Flat1/a 12 Fake Street, Fake Vill NE29 0EG', 'NE290EG'],
            ['NE29 0EG, CT13 9FD', 'NE290EG'],
            ['NE290EG CT13 9FD', 'NE290EG'],
            ['NE29 0EG CT13 9FD', 'NE290EG'],
            ['NE290EG', 'NE290EG'],
            ['NE2990EG', ''],
            ['NE29 90EG', ''],
            ['NE29 0EG', 'NE290EG'],
            ['  NE290EG   ', 'NE290EG'],
            ['', ''],
            [' ', ''],
            ['NE 290EG', 'NE290EG'],
            ['NE29-0EG', 'NE290EG'],
            ['NE290E G', 'NE290EG'],
        ];
    }

    /**
     * @dataProvider inputPostcodesValidator
     * @test
     *
     * @param string $postcode
     * @param bool $outcome
     */
    public function postcodeValidator($postcode, $outcome): void
    {
        $this->assertEquals(Postcode::validate($postcode), $outcome);
    }

    /**
     * @test
     */
    public function throwExceptionIfBadPostcodeIsPassed()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Postcode('BANGARANG');
    }

    /**
     * @test
     */
    public function getPostcodeBack()
    {
        $postcode = 'NE29 0EG';

        $pcObj = new Postcode($postcode);

        $this->assertEquals(Postcode::format($postcode), $pcObj->get());
    }

    /**
     * @dataProvider inputPostcodesParts
     * @test
     *
     * @param string $postcode
     * @param bool $outcome
     * @param string $outward
     * @param string $inward
     * @param string $area
     * @param string $district
     * @param string $sector
     * @param string $unit
     */
    public function getPostcodeParts($postcode, $outcome, $outward, $inward, $area, $district, $sector, $unit)
    {
        $pcObj = new Postcode($postcode);

        // Outward
        $this->assertEquals(
            ($pcObj->getOutward() == $outward),
            $outcome
        );

        // Inward
        $this->assertEquals(
            ($pcObj->getInward() == $inward),
            $outcome
        );

        // Area
        $this->assertEquals(
            ($pcObj->getArea() == $area),
            $outcome
        );

        // District
        $this->assertEquals(
            ($pcObj->getDistrict() == $district),
            $outcome
        );

        // sector
        $this->assertEquals(
            ($pcObj->getSector() == $sector),
            $outcome
        );

        // unit
        $this->assertEquals(
            ($pcObj->getUnit() == $unit),
            $outcome
        );
    }

    /**
     * @dataProvider inputFindInString
     * @test
     *
     * @param string $term
     * @param mixed $postcode
     */
    public function pullPostCodeFromString(string $term, $postcode = false)
    {
        $foundPostcode = Postcode::findInString($term);

        if ($foundPostcode instanceof Postcode) {
            $foundPostcode = $foundPostcode->get();
        }

        $this->assertEquals(
            $postcode,
            $foundPostcode,
            "Did not find postcode as expected when pulling from a string"
        );
    }
}