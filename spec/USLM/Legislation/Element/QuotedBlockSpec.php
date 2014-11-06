<?php

namespace spec\USLM\Legislation\Element;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuotedBlockSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('USLM\Legislation\Element\QuotedBlock');
    }

    function it_should_return_as_markdown() {
      $raw = '<quoted-block display-inline="no-display-inline" id="H8535149437C447C7BF1F81700BAAEEA5" style="OLC">
                  <section id="H10D0419BBA8441EA923C1A07FD09FA34">
                    <enum>5211.</enum>
                    <header>Authorization of appropriations</header>
                    <text display-inline="no-display-inline">There are authorized to be appropriated to carry out this subpart $300,000,000 for fiscal year 2015 and each of the 5 succeeding fiscal years.</text>
                  </section>
                  <after-quoted-block>.</after-quoted-block>
                </quoted-block>';

      $expected = "";
      $expected .= "> 5211. Authorization of appropriations\n";
      $expected .= ">   There are authorized to be appropriated to carry out this subpart $300,000,000 for fiscal year 2015 and each of the 5 succeeding fiscal years.\n";
      $expected .= ".";

      $simplexml = simplexml_load_string($raw);

      $this->simplexml($simplexml);

      $this->asMarkdown()->shouldBe($expected);
    }

    function it_should_handle_subsection_children() {
      $raw = '<quoted-block style="OLC" id="H1B2EC132803F480F8841EEBBF9E46280" display-inline="no-display-inline">
                <subsection id="H311CAB4BF827411384F96403E73208A3">
                  <enum>(g)</enum>
                  <header>Public Disclosure of LNG Export Destinations</header>
                  <text display-inline="yes-display-inline">As a condition for approval of any authorization to export LNG, the Secretary of Energy shall require the applicant to publicly disclose the specific destination or destinations of any such authorized LNG exports.</text>
                </subsection>
                <after-quoted-block>.</after-quoted-block>
              </quoted-block>';

      $expected = "";
      $expected .= "> (g) Public Disclosure of LNG Export Destinations\n";
      $expected .= ">   As a condition for approval of any authorization to export LNG, the Secretary of Energy shall require the applicant to publicly disclose the specific destination or destinations of any such authorized LNG exports.\n";
      $expected .= ".";

      $simplexml = simplexml_load_string($raw);
      $this->simplexml($simplexml);
      $this->asMarkdown()->shouldBe($expected);
    }

    function it_should_handle_subparagraph_children() {
      $raw = '<quoted-block style="OLC" id="HB5E322CB6DFA412FA4A9073070764E02" display-inline="no-display-inline">
                <subparagraph id="HCB3F0A02C8984ABAB30F431D6EA8BC1E">
                  <enum>(D)</enum>
                  <text display-inline="yes-display-inline">that is under the jurisdiction of the Secretary of Defense or the Secretary of a military department;</text>
                </subparagraph>
                <after-quoted-block>.</after-quoted-block>
              </quoted-block>';

      $expected = "";
      $expected .= "> (D) that is under the jurisdiction of the Secretary of Defense or the Secretary of a military department;\n";
      $expected .= ".";

      $simplexml = simplexml_load_string($raw);
      $this->simplexml($simplexml);
      $this->asMarkdown()->shouldBe($expected);
    }

    function it_should_handle_clause_children() {
      $raw = '<quoted-block display-inline="no-display-inline" id="H874EE187D639471DBED781E6030AD5C2" style="OLC">
                <clause id="HCFBA055CCC1F41E79A644817CEB7C87F">
                  <enum>(ii)</enum>
                  <text display-inline="yes-display-inline">any purchase or sale of a nonfinancial commodity or security for deferred shipment or delivery, so
               long as the transaction is intended to be physically settled, including
               any stand-alone or embedded option for which exercise results in a
               physical delivery obligation;</text>
                </clause>
                <after-quoted-block>.</after-quoted-block>
              </quoted-block>';

      $expected = "";
      $expected .= "> (ii) any purchase or sale of a nonfinancial commodity or security for deferred shipment or delivery, so long as the transaction is intended to be physically settled, including any stand-alone or embedded option for which exercise results in a physical delivery obligation;\n";
      $expected .= ".";

      $simplexml = simplexml_load_string($raw);
      $this->simplexml($simplexml);
      $this->asMarkdown()->shouldBe($expected);
    }

    function it_should_handle_continuation_text() {
      $raw = '<quoted-block display-inline="no-display-inline" id="HFCAAB758D1F54565B93ED92F51CC6BF8" style="OLC">
                <quoted-block-continuation-text quoted-block-continuation-text-level="section">For purposes of this section, the term <term>minister of the gospel</term> includes any duly recognized official of a religious, spiritual, moral, or ethical organization
             (whether theistic or not).</quoted-block-continuation-text>
                <after-quoted-block>.</after-quoted-block>
              </quoted-block>';

      $expected = "";
      $expected .= "> For purposes of this section, the term \"minister of the gospel\" includes any duly recognized official of a religious, spiritual, moral, or ethical organization (whether theistic or not).\n";
      $expected .= ".";

      $simplexml = simplexml_load_string($raw);
      $this->simplexml($simplexml);
      $this->asMarkdown()->shouldBe($expected);
    }

    function it_should_handle_toc_children() {
      $raw = '<quoted-block display-inline="no-display-inline" id="H9211C218C97B4B5B99772B898115530A" style="USC">
                <toc regeneration="no-regeneration">
                  <toc-entry level="section">21110. Grade crossing exception.</toc-entry>
                </toc>
                <after-quoted-block>.</after-quoted-block>
              </quoted-block>';

      $expected = "";
      $expected .= "> 21110. Grade crossing exception.\n";
      $expected .= ".";

      $simplexml = simplexml_load_string($raw);
      $this->simplexml($simplexml);
      $this->asMarkdown()->shouldBe($expected);
    }

    function it_should_handle_text_children() {
      $raw = '<quoted-block display-inline="yes-display-inline" id="HB0FB2BF353304463A80EC63111E3CC50" style="USC">
                <text>this section:</text>
                <paragraph id="HBE3478C1C6FC42BEB7A973848F65F973" indent="up1">
                  <enum>(1)</enum>
                  <text display-inline="yes-display-inline">The</text>
                </paragraph>
                <after-quoted-block>; and</after-quoted-block>
              </quoted-block>';

      $expected = "";
      $expected .= "> this section:\n";
      $expected .= "> (1) The\n";
      $expected .= "; and";

      $simplexml = simplexml_load_string($raw);
      $this->simplexml($simplexml);
      $this->asMarkdown()->shouldBe($expected);
    }
}