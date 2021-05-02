<div x-data="{ open: false }">
    <div @click="open = true">
        {{ $trigger }}
    </div>

    <div x-show="open" class='wt-modal' role="dialog" aria-modal="true">

        <div class="modal-wrapper">

            <div class="modal-backdrop" aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="modal-span" aria-hidden="true">&#8203;</span>

            <div class="modal-content" @click.away="open = false">
                {{ $slot }}
            </div>

        </div>

    </div>

</div>

@push('styles')
    <style>
        .wt-modal {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 10;
            overflow-y: auto
        }
        .modal-wrapper {
            display: flex;
            min-height: 100vh;
            align-items: flex-end;
            justify-content: center;
            padding: 1rem 1rem 5rem;
            text-align: center
        }
        @media (min-width: 640px) {

            .modal-wrapper {
                display: block;
                padding: 0px
            }
        }

        .modal-content {
            display: inline-block;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            transform: translateX(var(--tw-translate-x)) translateY(var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
            overflow: hidden;
            border-radius: 0.5rem;
            --tw-bg-opacity: 1;
            background-color: rgba(255, 255, 255, var(--tw-bg-opacity));
            text-align: left;
            vertical-align: bottom;
            --tw-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }

        @media (min-width: 640px) {

            .modal-content {
                margin-top: 2rem;
                margin-bottom: 2rem;
                width: 100%;
                max-width: 32rem;
                vertical-align: middle
            }
        }
        .modal-backdrop {
            position: fixed;
            top: 0px;
            right: 0;
            bottom: 0;
            left: 0;
            background-color: rgba(107, 114, 128, var(--tw-bg-opacity));
            --tw-bg-opacity: 0.75;
            transition-property: opacity;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms
        }
        .modal-span {
            display: none
        }
        @media (min-width: 640px) {
            .modal-span {
                display: inline-block;
                height: 100vh;
                vertical-align: middle
            }
        }
    </style>
@endpush
