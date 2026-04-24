<script lang="ts">
    import * as Table from '$lib/components/ui/table';
    import { capitalizeFirstLetter } from '@/lib/helpers';
    import type { User } from '@/types';
    import { Pencil, Trash, User as UserIcon } from '@lucide/svelte';
    import * as Avatar from '../ui/avatar';
    import { Button } from '../ui/button';
    import UserAvatar from './user-avatar.svelte';

    interface Props {
        users: Array<User>;
    }

    const { users }: Props = $props();
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
                <Table.Head>Amount</Table.Head>
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
                    <Table.Cell>{capitalizeFirstLetter(user.role)}</Table.Cell>
                    <Table.Cell>
                        <Button variant="outline"
                            ><Pencil />
                            <span class="hidden md:inline">Edit</span></Button
                        >
                        <Button variant="destructive">
                            <Trash />
                            <span class="hidden md:inline">Delete</span>
                        </Button>
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
