<?php

use PHPUnit\Framework\TestCase;

final class IndefiniteArticleTest extends TestCase
{
	public function testAbbreviationAn(): void {
		$this->assertEquals(
			'an SPC',
			IndefiniteArticle::A('SPC')
		);		
	}

	public function testAbbreviationA(): void {
		$this->assertEquals(
			'a BMW',
			IndefiniteArticle::A('BMW')
		);		
	}

	public function testExceptionHour(): void {
		$this->assertEquals(
			'an hour',
			IndefiniteArticle::A('hour')
		);		
	}

	public function testExceptionEuler(): void {
		$this->assertEquals(
			'an Euler number',
			IndefiniteArticle::A('Euler number')
		);		
	}

	public function testOrdinalAn(): void {
		$this->assertEquals(
			'an eighteenth birthday',
			IndefiniteArticle::A('eighteenth birthday')
		);		
	}

	public function testOrdinalA(): void {
		$this->assertEquals(
			'a sixteenth note',
			IndefiniteArticle::A('sixteenth note')
		);		
	}

	public function testDigitAn(): void {
		$this->assertEquals(
			'an 18th century artist',
			IndefiniteArticle::A('18th century artist')
		);		
	}

	public function testDigitA(): void {
		$this->assertEquals(
			'a 17th century artist',
			IndefiniteArticle::A('17th century artist')
		);		
	}

	public function testSingleLetterAn(): void {
		$this->assertEquals(
			'an L',
			IndefiniteArticle::A('L')
		);		
	}

	public function testSingleLetterA(): void {
		$this->assertEquals(
			'a J',
			IndefiniteArticle::A('J')
		);		
	}
}
