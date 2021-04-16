<?php

use Tests\TestCase;
use App\ArticleParser;
use Spatie\Snapshots\MatchesSnapshots;

class ArticleParserTest extends TestCase {
	use MatchesSnapshots;

	private $articleId = 0;

	private function _getArticleDataStub( string $content, string $title = null, string $slug = null ) : array {
		return [
			'id'      => ++$this->articleId,
			'title'   => $title ?? 'Test title',
			'slug'    => $slug ?? 'test-slug',
			'content' => $content,
		];
	}

	public function testPlainTextParagraphParsing() : void {
		$article = new ArticleParser( $this->_getArticleDataStub( 'Simple text' ) );
		self::assertEquals( [
			[
				'type'    => 'paragraph',
				'content' => 'Simple text',
			],
		], $article->getContent() );
	}

	public function testParagraphParsing() : void {
		$article = new ArticleParser( $this->_getArticleDataStub( '<p>Paragraph text</p>' ) );
		self::assertEquals( [
			[
				'type'    => 'paragraph',
				'content' => 'Paragraph text',
			],
		], $article->getContent() );
	}

	public function testParagraphParsingWithFormatting() : void {
		$article = new ArticleParser( $this->_getArticleDataStub( '<p>Paragraph <strong>text</strong></p>' ) );
		self::assertEquals( [
			[
				'type'    => 'paragraph',
				'content' => 'Paragraph <strong>text</strong>',
			],
		], $article->getContent() );
	}

	public function testImageParsing() : void {
		$article = new ArticleParser( $this->_getArticleDataStub( '<p>Paragraph</p><img src="http://example.com/image.jpg" alt="Alt text" />' ) );
		self::assertEquals( [
			[
				'type'    => 'paragraph',
				'content' => 'Paragraph',
			],
			[
				'type' => 'image',
				'src'  => 'http://example.com/image.jpg',
				'alt'  => 'Alt text',
			],
		], $article->getContent() );
	}
}
