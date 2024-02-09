<template>
    <li class="border-top-1 surface-border lg:border-top-none">
        <a v-ripple class="flex p-3 lg:px-3 lg:py-2 align-items-center hover:surface-100 font-medium border-round cursor-pointer
                    transition-duration-150 transition-colors p-ripple" @click="toggle">

            <i :class="currentLang" class="mr-3 lg:mr-0" style="width: 32px; height: 32px"/>
        </a>
    </li>

    <Menu ref="languageMenu" :model="languages" :popup="true"/>
</template>
<script>

export default {
    data() {
        return {
        }
    },
    methods  : {
        toggle(event) {
            this.$refs.languageMenu.toggle(event);
        }
    },
    computed : {
        languages() {
            const items = [
                {
                    label   : 'English',
                    icon    : 'fi fi-gb',
                    command : () => {
                        this.$inertia.visit(route('language', 'en'), {
                            method : 'post',
                        })
                    }
                },
                {
                    label   : 'Ελληνικά',
                    icon    : 'fi fi-gr',
                    command : () => {
                        this.$inertia.visit(route('language', 'gr'), {
                            method : 'post',
                        })
                    }
                },
            ];

            return this.$page.props.locale === 'gr' ? items.reverse() : items;

        },
        currentLang() {
            return this.$page.props.locale === 'en' ? 'fi fi-gb' : 'fi fi-gr';
        }
    }
}
</script>