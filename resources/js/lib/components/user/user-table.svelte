<script lang="ts">
    import * as Table from '$lib/components/ui/table';
    import { capitalizeFirstLetter } from '@/lib/helpers';
    import type { User } from '@/types';
    import { ShieldCogCorner, Trash, User as UserIcon } from '@lucide/svelte';
    import EditUser from '../form/superadmin-form/edit-user.svelte';
    import { Button } from '../ui/button';
    import UserAvatar from './user-avatar.svelte';
    import DeleteUser from '../form/superadmin-form/delete-user.svelte';

    interface Props {
        users: Array<User>;
        activeFilter: 'USER' | 'ADMIN' | 'SUPERADMIN' | 'ALL';
    }

    let { users = $bindable(), activeFilter = $bindable() }: Props = $props();
</script>

<section class="p-4">
    <Table.Root>
        <Table.Caption>Daftar Pengguna</Table.Caption>
        <Table.Header>
            <Table.Row>
                <Table.Head class="w-[100px]">#</Table.Head>
                <Table.Head>Avatar</Table.Head>
                <Table.Head>Nama</Table.Head>
                <Table.Head>Email</Table.Head>
                <Table.Head>Role</Table.Head>
                <Table.Head>Aksi</Table.Head>
            </Table.Row>
        </Table.Header>
        <Table.Body>
            {#each users as user, index (user.id)}
                <Table.Row>
                    <Table.Cell class="font-medium">{index + 1}</Table.Cell>
                    <Table.Cell>
                        <UserAvatar src={user.avatar} />
                    </Table.Cell>
                    <Table.Cell>{user.name}</Table.Cell>
                    <Table.Cell>{user.email}</Table.Cell>
                    <Table.Cell>
                        <div class="flex gap-2 items-center">
                            {#if user.role === 'USER'}
                                <UserIcon class="size-4" />
                            {:else}
                                <ShieldCogCorner class="size-4" />
                            {/if}
                            <span>
                                {capitalizeFirstLetter(user.role)}
                            </span>
                        </div>
                    </Table.Cell>
                    <Table.Cell>
                        <EditUser {user} bind:users bind:activeFilter />
                        <DeleteUser {user} bind:users bind:activeFilter />
                    </Table.Cell>
                </Table.Row>
            {/each}
        </Table.Body>
        <!-- <Table.Footer>
            <Table.Row>
                <Table.Cell colspan={3}>Total</Table.Cell>
                <Table.Cell class="text-end">$2,500.00</Table.Cell>
            </Table.Row>
        </Table.Footer> -->
    </Table.Root>
</section>
