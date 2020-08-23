<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8">
  <title>{{ $data->ref->site->title }}</title>
  <meta name="description" content="Terms of Use">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="/css/serenity.{{$data->ref->template->primaryColor}}.css" rel="stylesheet">
  <meta name="theme-color" content="#fafafa">
</head>


<body>
    <div class="w-full max-w-6xl mx-auto px-6 font-reading">

        <div class="w-full flex items-center justify-between py-4">
            <a href="/" class="flex items-center">
                @isset($data->ref->site->logo)
                <img src="{{$data->ref->site->logo}}" alt="Logo" class="h-12 w-12">
                @else
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current text-{{$data->ref->template->primaryColor}}-600 inline-block fill-current h-12 w-12" viewBox="0 0 512 512"><path d="M147 286a10 10 0 100 20 10 10 0 000-20zM147 326c-6 0-10 4-10 10v126a10 10 0 1020 0V336c0-6-5-10-10-10z"/><path d="M424 8a10 10 0 00-15-6c-10 7-61 45-69 67-5 14-4 28 3 41-12 17-25 42-36 65V10c0-6-5-10-10-10h-80c-6 0-10 4-10 10v196h-2l-17-66v-1l-16-57v-1-1l-1-1a10 10 0 00-1-1L111 8a10 10 0 00-17 4l-18 91-1 1a10 10 0 001 2v1l15 58 11 41a30 30 0 00-25 30c0 13 8 24 20 28v198c0 28 22 50 50 50h200c27 0 50-22 50-50V264a30 30 0 0020-28c0-15-11-27-25-29 7-27 12-53 13-74 14-5 24-16 29-29 8-23-7-84-10-96zm-68 118a50 50 0 0029 10c-2 20-7 45-13 70h-57c15-35 29-62 41-80zM227 20h60v23h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v23h-60V20zM109 36l41 49a46 46 0 01-53 14l12-63zm-9 85a66 66 0 0058-16l11 40 15 61h-62l-11-46-11-39zm277 341c0 17-14 30-30 30H147c-17 0-30-13-30-30V266h260v196zm20-226a10 10 0 01-10 10H107a10 10 0 010-20h280c5 0 10 4 10 10zm18-139a30 30 0 01-52 7c-6-8-7-18-4-28 4-10 28-32 49-49 6 27 11 59 7 70z"/></svg>
                @endisset
                <span class="pl-2 cursor-pointer font-heading text-2xl md:text-3xl font-bold text-{{$data->ref->template->primaryColor}}-600 opacity-75">{{ $data->ref->site->name }}</span>

            </a>
        </div>

        <div class="w-full mt-10 py-4 text-gray-700 max-w-3xl">

            <h1 class="text-4xl border-b py-4 mb-4">Terms of Use</h1>

            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Welcome to "{{ $data->ref->site->name }}"</h2>

            <p class="mb-8">These terms of service outline the rules and regulations for the use of "{{ $data->ref->site->name }}" Website.</p> <br />

            <p class="mb-8">By accessing this website we assume you accept these terms of service in full. Do not continue to use "{{ $data->ref->site->name }}" website
            if you do not accept all of the terms of service stated on this page.</p>
            <p class="mb-8">The following terminology applies to these Terms of Service, Privacy Statement and Disclaimer Notice
            and any or all Agreements: "Client", "You" and "Your" refers to you, the person accessing this website
            and accepting the Company's terms of service. "The Company", "Ourselves", "We", "Our" and "Us", refers
            to our Company. "Party", "Parties", or "Us", refers to both the Client and ourselves, or either the Client
            or ourselves. All terms refer to the offer, acceptance and consideration of payment necessary to undertake
            the process of our assistance to the Client in the most appropriate manner, whether by formal meetings
            of a fixed duration, or any other means, for the express purpose of meeting the Client's needs in respect
            of provision of the Company's stated services/products, in accordance with and subject to, prevailing law
            of . Any use of the above terminology or other words in the singular, plural,
            capitalisation and/or he/she or they, are taken as interchangeable and therefore as referring to same.</p>

            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Cookies</h2>
            <p class="mb-8">We employ the use of cookies. By using "{{ $data->ref->site->name }}" website you consent to the use of cookies
            in accordance with "{{ $data->ref->site->name }}"'s privacy policy.</p><p class="mb-8">Most of the modern day interactive web sites
            use cookies to enable us to retrieve user details for each visit. Cookies are used in some areas of our site
            to enable the functionality of this area and ease of use for those people visiting. Some of our
            affiliate / advertising partners may also use cookies.</p>

            <h2  class="mt-8 pb-2 text-2xl text-gray-800">License</h2>
            <p class="mb-8">Unless otherwise stated, "{{ $data->ref->site->name }}" and/or it's licensors own the intellectual property rights for
            all material on "{{ $data->ref->site->name }}". All intellectual property rights are reserved. You may view and/or print
            pages from {{ url('/') }} for your own personal use subject to restrictions set in these terms of service.</p>
            <p class="mb-8">You must not:</p>
            <ol class='list-disc mb-8'>
                <li>Republish material from {{ url('/') }}</li>
                <li>Sell, rent or sub-license material from {{ url('/') }}</li>
                <li>Reproduce, duplicate or copy material from {{ url('/') }}</li>
                <li>Redistribute content from "{{ $data->ref->site->name }}" (unless content is specifically made for redistribution).</li>
            </ol>


            <h2  class="mt-8 pb-2 text-2xl text-gray-800">User Comments</h2>
            <ol class='list-disc mb-8'>
                <li>This Agreement shall begin on the date hereof.</li>
                <li>Certain parts of this website offer the opportunity for users to post and exchange opinions, information,
                material and data ('Comments') in areas of the website. "{{ $data->ref->site->name }}" does not screen, edit, publish
                or review Comments prior to their appearance on the website and Comments do not reflect the views or
                opinions of"{{ $data->ref->site->name }}", its agents or affiliates. Comments reflect the view and opinion of the
                person who posts such view or opinion. To the extent permitted by applicable laws "{{ $data->ref->site->name }}"shall
                not be responsible or liable for the Comments or for any loss cost, liability, damages or expenses caused
                and or suffered as a result of any use of and/or posting of and/or appearance of the Comments on this
                website.</li>
                <li>"{{ $data->ref->site->name }}"reserves the right to monitor all Comments and to remove any Comments which it considers
                in its absolute discretion to be inappropriate, offensive or otherwise in breach of these Terms of Service.</li>
                <li>You warrant and represent that:
                    <ol class='list-disc mb-8'>
                        <li>You are entitled to post the Comments on our website and have all necessary licenses and consents to
                                do so;</li>
                        <li>The Comments do not infringe any intellectual property right, including without limitation copyright,
                            patent or trademark, or other proprietary right of any third party;</li>
                        <li>The Comments do not contain any defamatory, libelous, offensive, indecent or otherwise unlawful material
                            or material which is an invasion of privacy</li>
                        <li>The Comments will not be used to solicit or promote business or custom or present commercial activities
                            or unlawful activity.</li>
                        </ol>
                    </li>
                <li>You hereby grant to <strong>"{{ $data->ref->site->name }}"</strong> a non-exclusive royalty-free license to use, reproduce,
                edit and authorize others to use, reproduce and edit any of your Comments in any and all forms, formats
                or media.</li>
            </ol>
            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Hyperlinking to our Content</h2>
            <ol class='list-disc mb-8'>
                <li>The following organizations may link to our Web site without prior written approval:
                    <ol class='list-decimal ml-4 mb-4'>
                    <li>Government agencies;</li>
                    <li>Search engines;</li>
                    <li>News organizations;</li>
                    <li>Online directory distributors when they list us in the directory may link to our Web site in the same
                        manner as they hyperlink to the Web sites of other listed businesses; and</li>
                    <li>Systemwide Accredited Businesses except soliciting non-profit organizations, charity shopping malls,
                        and charity fundraising groups which may not hyperlink to our Web site.</li>
                    </ol>
                </li>

                <li>These organizations may link to our home page, to publications or to other Web site information so long
                    as the link: (a) is not in any way misleading; (b) does not falsely imply sponsorship, endorsement or
                    approval of the linking party and its products or services; and (c) fits within the context of the linking
                    party's site.
                </li>

                <li>We may consider and approve in our sole discretion other link requests from the following types of organizations:
                    <ol class='list-decimal ml-4 mb-4'>
                        <li>commonly-known consumer and/or business information sources such as Chambers of Commerce, American
                            Automobile Association, AARP and Consumers Union;</li>
                        <li>dot.com community sites;</li>
                        <li>associations or other groups representing charities, including charity giving sites,</li>
                        <li>online directory distributors;</li>
                        <li>internet portals;</li>
                        <li>accounting, law and consulting firms whose primary clients are businesses; and</li>
                        <li>educational institutions and trade associations.</li>
                    </ol>
                </li>
            </ol>
            <p class="mb-8">We will approve link requests from these organizations if we determine that: (a) the link would not reflect
            unfavorably on us or our accredited businesses (for example, trade associations or other organizations
            representing inherently suspect types of business, such as work-at-home opportunities, shall not be allowed
            to link); (b)the organization does not have an unsatisfactory record with us; (c) the benefit to us from
            the visibility associated with the hyperlink outweighs the absence of "{{ $data->ref->site->name }}"; and (d) where the
            link is in the context of general resource information or is otherwise consistent with editorial content
            in a newsletter or similar product furthering the mission of the organization.</p>

            <p class="mb-8">These organizations may link to our home page, to publications or to other Web site information so long as
            the link: (a) is not in any way misleading; (b) does not falsely imply sponsorship, endorsement or approval
            of the linking party and it products or services; and (c) fits within the context of the linking party's
            site.</p>

            <p class="mb-8">If you are among the organizations listed in paragraph 2 above and are interested in linking to our website,
            you must notify us by sending an e-mail to webmaster of this website.
            Please include your name, your organization name, contact information (such as a phone number and/or e-mail
            address) as well as the URL of your site, a list of any URLs from which you intend to link to our Web site,
            and a list of the URL(s) on our site to which you would like to link. Allow 2-3 weeks for a response.</p>

            <p class="mb-8">Approved organizations may hyperlink to our Web site as follows:</p>

            <ol class='list-disc mb-8'>
                <li>By use of our corporate name; or</li>
                <li>By use of the uniform resource locator (Web address) being linked to; or</li>
                <li>By use of any other description of our Web site or material being linked to that makes sense within the
                    context and format of content on the linking party's site.</li>
            </ol>
            <p class="mb-8">No use of "{{ $data->ref->site->name }}"'s logo or other artwork will be allowed for linking absent a trademark license
            agreement.</p>


            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Iframes</h2>
            <p class="mb-8">Without prior approval and express written permission, you may not create frames around our Web pages or
            use other techniques that alter in any way the visual presentation or appearance of our Web site.</p>

            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Reservation of Rights</h2>
            <p class="mb-8">We reserve the right at any time and in its sole discretion to request that you remove all links or any particular
            link to our Web site. You agree to immediately remove all links to our Web site upon such request. We also
            reserve the right to amend these terms of service and its linking policy at any time. By continuing
            to link to our Web site, you agree to be bound to and abide by these linking terms of service.</p>

            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Removal of links from our website</h2>
            <p class="mb-8">If you find any link on our Web site or any linked web site objectionable for any reason, you may contact
            us about this. We will consider requests to remove links but will have no obligation to do so or to respond
            directly to you.</p>
            <p class="mb-8">Whilst we endeavour to ensure that the information on this website is correct, we do not warrant its completeness
            or accuracy; nor do we commit to ensuring that the website remains available or that the material on the
            website is kept up to date.</p>

            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Content Liability</h2>
            <p class="mb-8">We shall have no responsibility or liability for any content appearing on your Web site. You agree to indemnify
            and defend us against all claims arising out of or based upon your Website. No link(s) may appear on any
            page on your Web site or within any context containing content or materials that may be interpreted as
            libelous, obscene or criminal, or which infringes, otherwise violates, or advocates the infringement or
            other violation of, any third party rights.</p>

            <h2  class="mt-8 pb-2 text-2xl text-gray-800">Disclaimer</h2>
            <p class="mb-8">To the maximum extent permitted by applicable law, we exclude all representations, warranties and conditions relating to our website and the use of this website (including, without limitation, any warranties implied by law in respect of satisfactory quality, fitness for purpose and/or the use of reasonable care and skill). Nothing in this disclaimer will:</p>
            <ol class='list-disc mb-8'>
            <li>limit or exclude our or your liability for death or personal injury resulting from negligence;</li>
            <li>limit or exclude our or your liability for fraud or fraudulent misrepresentation;</li>
            <li>limit any of our or your liabilities in any way that is not permitted under applicable law; or</li>
            <li>exclude any of our or your liabilities that may not be excluded under applicable law.</li>
            </ol>
            <p class="mb-8">The limitations and exclusions of liability set out in this Section and elsewhere in this disclaimer: (a)
            are subject to the preceding paragraph; and (b) govern all liabilities arising under the disclaimer or
            in relation to the subject matter of this disclaimer, including liabilities arising in contract, in tort
            (including negligence) and for breach of statutory duty.</p>
            <p class="mb-8">To the extent that the website and the information and services on the website are provided free of charge,
            we will not be liable for any loss or damage of any nature.</p>

        </div>

        <div class="w-full flex justify-center mt-6 p-4 border-t text-gray-400 rounded-lg">
                &copy; <?php echo date('Y') ?> - All Rights Reserved. Made with&nbsp;<a href="https://webtheory.co">WebTheory</a>
        </div>
    </div>

</body>
</html>