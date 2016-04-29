<?php

use chilimatic\lib\Parser\Annotation\AnnotationViewParser;

class AnnotationViewParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return string
     */
    public function invalidDocProvider() {
        return "
         /**
          * @var myRenderingClass
          */
        ";
    }

    /**
     * @return string
     */
    public function validViewRenderDocProvider() {
        return "
         /**
          * @view myRenderingClass
          */
        ";
    }

    /**
     * @return string
     */
    public function validViewDocProvider() {
        return "
         /**
          * @view myRenderingClass
          * @viewTemplate path/to/file
          */
        ";
    }

    /**
     * @return string
     */
    public function validViewDocNoRenderClassProvider() {
        return "
         /**
          * @viewTemplate path/to/file
          */
        ";
    }

    /**
     * @return string
     */
    public function validViewDocNoRenderClassWithParamsProvider() {
        return "
         /**
          * @viewTemplate path/to/file
          * @viewParam test=1
          * @viewParam asdfasf=4
          */
        ";
    }


    /**
     * @test
     */
    public function viewParserImplementsIFlyWeightParserInterface()
    {
        $parser = new AnnotationViewParser();

        self::assertInstanceOf('\chilimatic\lib\Interfaces\IFlyWeightParser', $parser);
    }

    /**
     * @test
     */
    public function viewParserWithInvalidStringInput()
    {
        $parser = new AnnotationViewParser();

        $result = $parser->parse($this->invalidDocProvider());

        self::assertEquals([], $result);
    }

    /**
     * @test
     */
    public function viewParserWithValidViewRenderStringInput()
    {
        $parser = new AnnotationViewParser();

        $result = $parser->parse($this->validViewRenderDocProvider());

        self::assertEquals(['myRenderingClass', null], $result);
    }

    /**
     * @test
     */
    public function viewParserWithValidViewTemplateStringInput()
    {
        $parser = new AnnotationViewParser();

        $result = $parser->parse($this->validViewDocProvider());

        self::assertEquals(['myRenderingClass', 'path/to/file'], $result);
    }

    /**
     * @test
     */
    public function viewParserWithValidViewTemplateStringAndNoRenderClassInput()
    {
        $parser = new AnnotationViewParser();

        $result = $parser->parse($this->validViewDocNoRenderClassProvider());

        self::assertEquals([null, 'path/to/file'], $result);
    }


    /**
     * @test
     */
    public function viewParserWithValidViewTemplateStringAndNoRenderClassAndParametersInput()
    {
        $parser = new AnnotationViewParser();

        $result = $parser->parse($this->validViewDocNoRenderClassWithParamsProvider());
        self::assertEquals(
            [
                null,
                'path/to/file',
                [
                    'test' => '1',
                    'asdfasf' => '4'
                ]
            ],
            $result);
    }
}