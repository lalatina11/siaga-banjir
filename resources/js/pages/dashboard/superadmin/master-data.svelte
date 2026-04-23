<script lang="ts">
    import DashboardLayout from '@/layouts/dashboard-layout.svelte';
    import AppHead from '@/lib/components/AppHead.svelte';
    import * as ButtonGroup from '@/lib/components/ui/button-group';
    import Button from '@/lib/components/ui/button/button.svelte';
    import * as InputGroup from '@/lib/components/ui/input-group';
    import UserTable from '@/lib/components/user/user-table.svelte';
    import { capitalizeFirstLetter } from '@/lib/helpers';
    import type { DefaultPageProps } from '@/lib/types';
    import type { User } from '@/types';
    import { usePage } from '@inertiajs/svelte';
    import { Plus, Search } from '@lucide/svelte';

    interface Props extends DefaultPageProps {
        users: Array<User>;
    }

    const filterUserByRole = ['ALL', 'USER', 'ADMIN'] as const satisfies Array<
        User['role'] | 'ALL'
    >;

    let activeFilter = $state<(typeof filterUserByRole)[number]>(
        filterUserByRole[0],
    );

    const { users: unfilteredUser } = usePage().props as Props;

    let search = $state('');

    let filteredUser = $derived(
        activeFilter === 'ALL'
            ? unfilteredUser
            : unfilteredUser.filter((user) => user.role === activeFilter),
    );

    let users = $derived(
        search
            ? filteredUser.filter(
                  (user) =>
                      user.name
                          .toLowerCase()
                          .includes(search.toLocaleLowerCase()) ||
                      user.email
                          .toLowerCase()
                          .includes(search.toLocaleLowerCase()),
              )
            : filteredUser,
    );

    const handleFilter = (filter: (typeof filterUserByRole)[number]) => {
        activeFilter = filter;
    };
</script>

<AppHead title="Master Data" />
<DashboardLayout>
    <main class="flex flex-col gap-3">
        <section class="p-4 flex flex-col gap-2">
            <ButtonGroup.Root>
                {#each filterUserByRole as filter (filter)}
                    <Button
                        size="lg"
                        onclick={() => handleFilter(filter)}
                        variant={filter === activeFilter
                            ? 'default'
                            : 'outline'}>{capitalizeFirstLetter(filter)}</Button
                    >
                {/each}
            </ButtonGroup.Root>
            <InputGroup.Root class="w-fit">
                <InputGroup.Input placeholder="Search..." bind:value={search} />
                <InputGroup.Addon align="inline-start">
                    <Search />
                </InputGroup.Addon>
            </InputGroup.Root>
            <Button class="w-fit" size="lg"><Plus /> Tambah User</Button>
        </section>
        <UserTable {users} />
    </main>
</DashboardLayout>
